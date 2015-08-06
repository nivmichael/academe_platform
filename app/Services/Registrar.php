<?php namespace App\Services;

use DB;
use Auth;
use Hash;
use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use Response;
use Input;
class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		
		if(!Auth::user()){
			
		
			
			return Validator::make($data['user']['personalInfo'], [
				'first_name' => 'required|min:3',
				'last_name' => 'required|max:255',
				'email' => 'required|email|max:255|unique:type_user',
				'password' => 'required|min:6' 
			]);
		}	
	}
			
		
	



	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		
		$authId;
		$obj = false;
		$all = Input::all();
		
	if(!Auth::user()){
	
			 $personalInfo = User::create([		
				// 'type'             => $data['type'],
				'subtype'     	   => $data['user']['personalInfo']['subtype'],
				'status'     	   => $data['user']['personalInfo']['status'],
				'first_name'       => $data['user']['personalInfo']['first_name'],
				'last_name'        => $data['user']['personalInfo']['last_name'],
				'email'            => $data['user']['personalInfo']['email'],
				'password'         => bcrypt($data['user']['personalInfo']['password']),
				'street_1'         => $data['user']['personalInfo']['street_1'],
				'street_2'    	   => $data['user']['personalInfo']['street_2'],
				'city'        	   => $data['user']['personalInfo']['city'],
				'state'       	   => $data['user']['personalInfo']['state'],
				'country'          => $data['user']['personalInfo']['country'],
				'zipcode'     	   => $data['user']['personalInfo']['zipcode'],
				'phone_1'     	   => $data['user']['personalInfo']['phone_1'],
				'phone_2'     	   => $data['user']['personalInfo']['phone_2'],
				'mobile'      	   => $data['user']['personalInfo']['mobile'],
			    'date_of_birth'    => $data['user']['personalInfo']['date_of_birth'],
				'registration'     => $data['user']['personalInfo']['registration'],
				'send_newsletters' => $data['user']['personalInfo']['send_newsletters'],
				'remember_token'   => $data['user']['personalInfo']['remember_token']
			]);
			
			$obj['personalInfo'] = $personalInfo['original'];
			$authId = $personalInfo->id;
		}else{
			//print_r(Auth::user()->id);die;
		$authId = Auth::user()->id;
		$userId =$authId;
		$personalInfo = Auth::user();
		
		}		
			
		foreach($all['user'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}
		
		if($obj['personalInfo']) {
			unset($obj['personalInfo']);
		}
		unset($obj['files']);
			foreach($obj as $docParamName => $docParamVals) {
			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->pluck('id');
			$iterableCount = 0;
			foreach($docParamVals as $param => $props) {
			
				if(is_int($param)) {
					foreach($props as $propKey => $propVal) {
					$paramValue = $propVal['paramValue'];
					$paramName  = $propVal['paramName'];
					$iterable = $param;
					
					$param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->pluck('id');
					
						if ($param_id) {
							//checking where the values come from? from param_value? or from short/long?
							$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
							
							if($iterable){
								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$authId)->pluck('id');
							}else{
								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',NULL)->where('ref_id',$authId)->pluck('id');
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
					
					$paramValue = $props;
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
	
	
return $personalInfo;
		
	}
}