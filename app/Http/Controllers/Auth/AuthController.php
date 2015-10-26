<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use DB;
use Auth;
use Hash;
use Response;
use Input;
use Socialite;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
		
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;


	
	protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
	
	public function getEmployerLogin()
    {
        	
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

		
        return view('auth.employerLogin');
    }
	public function getJobseekerLogin()
    {
        	
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

		
        return view('auth.jobseekerLogin');
    }
	
	public function getJobseekerRegister()
    {
        return view('auth.register_jobseeker');
    }
	
	public function getEmployerRegister()
    {
        return view('auth.register_employer');
    }
	
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
//             'first_name' => 'required|max:255',
//             'email' => 'required|email|max:255|unique:type_user',
//             'password' => 'required|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data)
	{


		// dd($data['user']['personal_information']['subtype']);	
		
		$authId;
		$obj = false;
		$all = Input::all();

	if(!Auth::user()){
	
		
			 $personal_information = User::create([		
				// 'type'             => $data['type'],
				'subtype'     	   => $data['user']['personal_information']['subtype'],
				'status'     	   => $data['user']['personal_information']['status'],
				'first_name'       => $data['user']['personal_information']['first_name'],
				'gender'           => $data['user']['personal_information']['gender'],
				'martial_status'   => $data['user']['personal_information']['martial_status'],
				'education_status' => $data['user']['personal_information']['education_status'],
				'last_name'        => $data['user']['personal_information']['last_name'],
				'email'            => $data['user']['personal_information']['email'],
				'password'         => bcrypt($data['user']['personal_information']['password']),
				'street_1'         => $data['user']['personal_information']['street_1'],
				'city'        	   => $data['user']['personal_information']['city'],
				'state'       	   => $data['user']['personal_information']['state'],
				'country'          => $data['user']['personal_information']['country'],
				'zipcode'     	   => $data['user']['personal_information']['zipcode'],
				'phone_1'     	   => $data['user']['personal_information']['phone_1'],
				'mobile'      	   => $data['user']['personal_information']['mobile'],
			    'date_of_birth'    => $data['user']['personal_information']['date_of_birth'],
				'registration'     => $data['user']['personal_information']['registration'],
				'send_newsletters' => $data['user']['personal_information']['send_newsletters'],
				'remember_token'   => $data['user']['personal_information']['remember_token'],

			]);
			
			$obj['personal_information'] = $personal_information['original'];
			$authId = $personal_information->id;
		}else{
			//print_r(Auth::user()->id);die;
		$authId = Auth::user()->id;
		$userId =$authId;
		$personal_information = Auth::user();
		
		}		
			
		foreach($all['user'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}
		
		if($obj['personal_information']) {
			unset($obj['personal_information']);
		}
		unset($obj['files']);
			foreach($obj as $docParamName => $docParamVals) {

			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->pluck('id');
			$iterableCount = 0;
			foreach($docParamVals as $param => $props) {
			
				if(is_int($param)) {
					foreach($props as $propKey => $propVal) {
						if($propVal['paramValue']){
							
							$paramValue = $propVal['paramValue'];
						}else{
							$paramValue='';
						};
					$paramName  = $propVal['paramName'];
					$iterable = $param;
					
					$param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->pluck('id');
					
						if ($param_id) {
							//checking where the values come from? from param_value? or from short/long?
							$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
// 							
							$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$authId)->pluck('id');
								if(!$existsId) {
									$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$authId)->pluck('id');
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
				}else if(!is_int($param)){
					
					$paramValue = $props['paramValue'];
					$param_id = DB::table('param')->where('name',  $param)->where('doc_param_id', $doc_param_id)->pluck('id');
					if($param_id == null) {
						dd('some thing wrong with param: '.$param);
					}

					$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
					$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$authId)->pluck('id');
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
	
	//DB::table('type_user')->where('id',$authId)->update(['registration'=>date(date("Y-m-d H:i:s"))]);

		//var_dump($obj);die;
return $personal_information;
		
	}

 /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();
		// OAuth Two Providers
		$token = $user->token;
		
		// OAuth One Providers
		$token = $user->token;
		$tokenSecret = $user->tokenSecret;
		
		// All Providers
		$user->getId();
		$user->getNickname();
		$user->getName();
		$user->getEmail();
		$user->getAvatar();
        // $user->token;
    }






}
