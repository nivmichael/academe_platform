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
			
		
		//	print_r($obj);
		foreach($obj as $docParam=>$values) {
			$doc_sub_type = DB::table('type_user')->where('id', $authId)->pluck('subtype');
			$doc_param_id = DB::table('doc_param')->where('name', $docParam)->where('doc_type_id', 1)->where('doc_sub_type', $doc_sub_type)->pluck('id');
			$iterableCount = null;
			foreach($values as $param_name=>$param_value) {
				$param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');
				//print_r('a'.$param_value);
				
				if(is_array($param_value)) {
				
					$iterable = $param_value;
					foreach($iterable as $m => $n) {
						
						$param_id = DB::table('param')->where('name', $m)->where('doc_param_id', $doc_param_id)->pluck('id');
						if ($param_id) {
							$value_ref = DB::table('param_value')->where('value', $n)->pluck('id');
							if(!$value_ref) {
							
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$n,'value_long'=>NULL]);
								} else {
								 
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								
							}
						}
					}
			} elseif (!is_array($param_value)) {
					//dd('a');
						
					if ($param_id) {
					// /dd($param_id);
						$value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');
						$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$authId)->pluck('id');
						
						
						
						if($existsId) {
							
							if(!$value_ref) {						
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$param_value,'value_long'=>NULL]);	
							} else {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
							}
							
							
							
						}else {
							
							
							if(!$value_ref) {						
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$param_value,'value_long'=>NULL]);	
							} else {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
							}
							
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