<?php namespace App\Services;

use DB;
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
		return Validator::make($data, [
			// 'first_name' => 'required|min:3',
			// 'last_name' => 'required|max:255',
			// 'email' => 'required|email|max:255|unique:type_user',
			//'password' => 'required|confirmed|min:6',
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
		

		$obj = false;
		$all = Input::all();
       	
		
		// foreach($all as $p=>$v) {
// 			
			// $explode = explode("__",$p);
			// $obj[$explode[0]] = array();
		// }
		// var_dump($obj);
		$personalInfo = User::create([
			
			// 'type'             => $data['type'],
			'subtype'     	   => $data['user']['personalInfo']['subtype'],
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
		foreach($data['user'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}
// 		
			// foreach($data as $k=>$v) {
				// if($k != '_token') {
					// $explode = explode('__',$k);
				// }	
// 				
			// //	var_dump($explode);
				// $doc_param = $explode[0];
				// $paramName = $explode[1];
// 				
				// $obj[$doc_param][$paramName] = $v;
			 // }
		
		
		
foreach($obj as $doc_param => $values) {
			$doc_param_id = DB::table('doc_param')->where('name', $doc_param)->pluck('id');
			foreach ($values as $param_name => $param_value) {
				$param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');
				
				if ($param_id) {
					//checking where the values come from? from param_value? or from short/long?
					$value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');
					
					if(!$value_ref) {
						
						if($param_value){
							$value_ref = $param_value;
						} else {
							$value_ref = NULL;
						};
						
						
						$update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $personalInfo->id)->update(['value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
						if(!$update) {
							
							DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $personalInfo->id)->insert(['doc_type'=>1,'ref_id'=>$personalInfo->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
						}
					} else {
					
				
							$update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id',  $personalInfo->id)->update(['value_ref'=>$value_ref,'value_short'=>null,'value_long'=>null]);
							if(!$update) {
							DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $personalInfo->id)->insert(['doc_type'=>1,'ref_id'=>$personalInfo->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);	
						}
					}
				}
			}
		}

return $personalInfo;
	}

}

// $all = Input::all();
// 	
		// $allPersonalInfo = $all['personalInfo'];
		// unset($all['personalInfo']);
	// //personalInfo //no dynamic parameters	
		// $id = $allPersonalInfo['id'];
		// $param = User::find($id);
		// if($param){		
				// $param->id = $id;	
		// }else{
			// $param = new User();
		// }
		// $param->type       = $allPersonalInfo['type'];
		// $param->email      = $allPersonalInfo['email'];
		// $param->password   = Hash::make(Input::get('password'));    
		// //$param->password_new = Input::get('password_new');
		// $param->first_name = $allPersonalInfo['first_name'];
		// $param->last_name  = $allPersonalInfo['last_name'];
		// $param->street_1   = $allPersonalInfo['street_1'];
		// $param->street_2   = $allPersonalInfo['street_2'];
		// $param->city 	   = $allPersonalInfo['city'];
		// $param->state      = $allPersonalInfo['state'];
		// $param->zipcode    = $allPersonalInfo['zipcode'];
		// $param->country    = $allPersonalInfo['country'];
		// $param->phone_1    = $allPersonalInfo['phone_1'];
		// $param->phone_2    = $allPersonalInfo['phone_2'];
		// $param->mobile     = $allPersonalInfo['mobile'];
// 		
		// $param->date_of_birth = new DateTime($allPersonalInfo['date_of_birth']);
		// $param->date_of_birth->format('Y-m-d');
		// $param->last_login = new DateTime('now');
// 		
		// $param->registration   = $allPersonalInfo['registration'];
		// $param->send_newsletters  = $allPersonalInfo['send_newsletters'];
		// $param->save();
// 		
// // 	
// 		
		// foreach($all as $doc_param => $values) {
			// $doc_param_id = DB::table('doc_param')->where('name', $doc_param)->pluck('id');
// 			
			// foreach ($values as $param_name => $param_value) {
				// $param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');
// 				
// 				
				// if ($param_id) {
					// //checking where the values come from? from param_value? or from short/long?
					// $value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');
// 					
					// if(!$value_ref) {
// 						
						// $value_ref = $param_value;
// 						
// 						
						// $update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $param->id)->update(['value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
						// if(!$update) {
// 							
							// DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $param->id)->insert(['doc_type'=>$param->type,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
						// }
					// } else {
// 					
// 				
							// $update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $id)->update(['value_ref'=>$value_ref,'value_short'=>null,'value_long'=>null]);
							// if(!$update) {
							// DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $param->id)->insert(['doc_type'=>$param->type,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);	
						// }
					// }
				// }
			// }
		// }
// 
		// return Response::json($param);
