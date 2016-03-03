<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;
use Auth;
use Mail;
use DB;
use Response;
use Input;
use Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthenticateController extends Controller
{
    use ThrottlesLogins,AuthenticatesAndRegistersUsers;
    public $username = "";

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth', ['except' => ['authenticate','signup']]);

    }

    public function loginUsername() {
        return $this->username;
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $this->username = $request->email;

        $this->validate($request, [
            'email' => 'required', 'password' => 'required',
        ]);


        $email = $request->input('email');
        $password = $request->input('password');
        $user = User::where('email', '=', $email)->first();
        if (!$user)
        {
            return Response::json(['error'=>'These Credentials do not exist in our records'], 401 );
        }
        if (!Hash::check($password, $user->password))
        {
            return response()->json(['error' => 'Wrong Password'], 401);
        }

        $throttles = $this->isUsingThrottlesLoginsTrait();
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return response()->json(['error' => 'too many attempts'], 401);
        }

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                if ($throttles) {
                    $this->incrementLoginAttempts($request);
                }
                return response()->json(['error' => 'These Credentials do not exist in our records-line 82'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // if no errors are encountered we can return a JWT
        return compact('token');
    }

    public function test(Request $request)
    {
        dd(Auth::user());
    }

    public function logout(Request $request)
    {
        $token = JWTAuth::getToken();
        $res = JWTAuth::invalidate($token);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return compact('user');
    }

    public function signup(Request $request)
    {

        $AuthedUser = $this->getAuthenticatedUser();
        $all = $request->all();

        $rules = [
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'email'      => 'email|required|max:255|unique:type_user',
            'password'   => 'required|min:6',
        ];

        if(!Auth::check()){
            $validator = Validator::make($request->get('personal_information'), $rules);
            if ($validator->fails()) {
                return response()->json( $validator->messages() , 422);
            }

            $personal_information = [
                'first_name' => $request['personal_information']['first_name'],
                'last_name'  => $request['personal_information']['last_name'],
                'email'      => $request['personal_information']['email'],
                'password'   => Hash::make($request['personal_information']['password']),
                'subtype' => $request['personal_information']['subtype'],
                'status' => $request['personal_information']['status'],
                'gender' => $request['personal_information']['gender'],
                'martial_status' => $request['personal_information']['martial_status'],
                'education_status' => $request['personal_information']['education_status'],
                'street_1' => $request['personal_information']['street_1'],
                'city' => $request['personal_information']['city'],
                'state' => $request['personal_information']['state'],
                'country' => $request['personal_information']['country'],
                'zipcode' => $request['personal_information']['zipcode'],
                'phone_1' => $request['personal_information']['phone_1'],
                'mobile' => $request['personal_information']['mobile'],
                'date_of_birth' => $request['personal_information']['date_of_birth'],
                //'registration' => $request['personal_information']['registration'],
                'send_newsletters' => $request['personal_information']['send_newsletters'],
                'remember_token' => $request['personal_information']['remember_token'],
            ];
           // dd($personal_information);
            $user = User::create($personal_information);
            $token = JWTAuth::fromUser($user);
            $authId = $user->id;

            unset($all['personal_information']);
        }else{
            $authId = Auth::user()->id;
            $User   = User::find($authId);
            $token  = JWTAuth::fromUser($User);

        }
        foreach($all as $doc_param => $param_object){
            foreach ($param_object as $param_key => $param_value) {
                $obj[$doc_param][$param_key] = $param_value;
            }
        }
        unset($obj['personal_information']);

        foreach($obj as $docParamName => $docParamVals) {
            $doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->value('id');
            $iterableCount = 0;
            foreach($docParamVals as $param => $props) {
                //dd(array_key_exists ( 'docParamId' , $docParamVals ));
                //dd($docParamVals);
                if(!array_key_exists ( 'docParamId' , $docParamVals )) {
                    //print_r('array');
                    foreach($props as $propKey => $propVal) {
                        if(isset($propVal['paramValue'])){

                        }else{
                            //print_r($propKey);
                        }
                        if($propVal['paramValue']){


                            $paramValue = $propVal['paramValue'];
                            if(is_array($paramValue)) {
                                $paramValue = implode('|',$paramValue);
                                //print_r($paramValue);
                            }

                        }else{
                            $paramValue='';
                        };
                        $paramName  = $propVal['paramName'];
                        $iterable = $param;

                        $param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->value('id');

                        if ($param_id) {
                            //checking where the values come from? from param_value? or from short/long?
                            $value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');

                            $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$authId)->value('id');
                            if(!$existsId) {
                                $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$authId)->value('id');
                            }



                            if($existsId) {

                                if(!$value_ref) {
                                    DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
                                } else {
                                    DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
                                }
                            }else {
                                if(!$value_ref) {
                                    DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
                                } else {
                                    DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
                                }
                            }
                        }

                    }
                }else if(array_key_exists ( 'docParamId' , $docParamVals )){

                    //print_r('single');
                    if(isset($props['paramValue'])){
                        $paramValue = $props['paramValue'];
                    }else{
                        //print_r('here');
                        $paramValue= '';
                    }


                    if(is_array($paramValue)) {
                        $paramValue = implode('|',$paramValue);

                    }
                    //print_r($paramValue);
                    $param_id = $param;
                    //$param_id = DB::table('param')->where('id',  $param)->where('doc_param_id', $doc_param_id)->value('id');
                    if($param_id == null) {
                        dd('some thing wrong with param: '.$param);
                    }

                    $value_ref = DB::table('param_value')->where('id', $paramValue)->value('id');
                    $existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$authId)->value('id');
                    if($existsId) {
                        if(!$value_ref) {
                            DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
                        } else {
                            DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
                        }
                    } else {
                        if(!$value_ref) {
                            DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
                        } else {
                            DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
                        }
                    }
                }
                $iterableCount ++;
            }
        }

        //need to send this somhow else because its delaying the next form

//        Mail::send('emails.welcome_jobseeker', $mailData, function($message) use ($mailData)
//        {
//            $message->from('no-reply@site.com', "AcadeME");
//            $message->subject("Welcome to AcadeME");
//            $message->to($mailData['email']);
//        });
        //return $personal_information;

    //}


        return response()->json(['token' => $token]);
        //return compact('token');
    }

}
