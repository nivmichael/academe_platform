<?php namespace App\Http\Controllers;

use DB;
use Response;
use Input;
use DateTime;
use App\User;
use App\param;
use App\paramValue;
use App\SysParamValues;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use stdClass;
use Schema;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Hash;
use Auth;;
use Illuminate\Http\Request;

class TypeUserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = DB::table('type_user')
		->get();		
		
		return Response::json($users);
	}
	public function columnIndex()
	{
		
		$columns = Schema::getColumnListing('type_user');
		$columns = (object) $columns;
// 		
		// return Response::json(array($columns,$params));
		return Response::json($columns);
	}
	
	public function columnIndexJobSeeker()
	{	
		$personal_information = new stdClass();
		$user = array();	
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.slug AS slug,
											   param.name AS paramName, 
											   doc_param.name AS docParamName,
											   param_type.name AS paramType,
											   doc_param.id AS docParamId
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
											   LEFT JOIN param_type ON param.type_id = param_type.id
											   WHERE doc_type_id = 1 
											   AND doc_param.doc_sub_type = 'jobSeeker'
											   AND authorized = 1"));
		if(!Auth::user()){
			$userpersonal_information = Schema::getColumnListing('type_user');
			$userpersonal_information = (object)$userpersonal_information;			
			foreach($userpersonal_information as $key=>$value) {
				$personal_information->$value = '';
			}
		}else {		
			$id = Auth::user()->id;		
			$personal_information = User::find($id);		
		}
		$user['personal_information'] = $personal_information;
		// $user['personal_information']->password_confirmation = '';
		foreach($params as $k=>$v) {
		
			//$user[$v->docParamName][$paramName] = $v->value = '';
			
			$iteration    = $v->iteration;
			$docParamId  = $v->docParamId;
			$docParamName = $v->docParamName;
			$paramName    = $v->paramName;
			$inputType    = $v->paramType;
			$slug         = $v->slug;
	
			
			$user[$docParamName]['docParamId'] = $docParamId;
			$user[$docParamName][$paramName]['paramName'] = $paramName;		
			$user[$docParamName][$paramName]['paramValue'] = '';
			$user[$docParamName][$paramName]['inputType'] = $inputType;
			$user[$docParamName][$paramName]['slug'] = $slug;		
		}	
		
		
				
		return Response::json($user);
	}
	
	public function columnIndexEmployer()
	{	
		$personal_information = new stdClass();
		$user = array();	
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.name AS paramName, 
											   doc_param.name AS docParamName ,
											   param_type.name AS paramType
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
											   LEFT JOIN param_type ON param.type_id = param_type.id
											   WHERE doc_type_id = 1 
											   AND doc_param.doc_sub_type = 'employer'
											   AND authorized = 1"));
		if(!Auth::user()){
			$userpersonal_information = Schema::getColumnListing('type_user');
			$userpersonal_information = (object)$userpersonal_information;			
			foreach($userpersonal_information as $key=>$value) {
				$personal_information->$value = '';
			}
		}else {		
			$id = Auth::user()->id;		
			$personal_information = User::find($id);		
		}
		$user['personal_information'] = $personal_information;
		// $user['personal_information']->password_confirmation = '';
		foreach($params as $k=>$v) {
			$iteration    = $v->iteration;
			$docParamName = $v->docParamName;
			$paramName    = $v->paramName;
			$inputType    = $v->paramType;
	
			
			
			$user[$docParamName][$paramName]['paramName'] = $paramName;		
			$user[$docParamName][$paramName]['paramValue'] = '';
			$user[$docParamName][$paramName]['inputType'] = $inputType;
		}	
		
		
				
		return Response::json($user);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	
	/**
	 * 
	 *
	 * @return Response
	 */
	public function setStatus()
	{
		$id = Auth::user()->id;
		if(isset($_POST['status'])){
			$status = $_POST['status'];
		}else{
			
			$status = $_POST['name'];
		}				
		
		// var_dump($status);		
// 			
// 		
		$user = User::find($id);
			
		$user->status = $status;
		
		$user->save();
		return Response::json($user->status);
	}
	public function getStatus()
	{
		$status = $_GET;
		
		$user = User::find(Auth::user()->id);
		$user->status = $status['name'];
		return Response::json($user->status);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$all = Input::all();
		if(isset($all['from']) && $all['from'] == 'tables'){
			$funcFromAdmin = true;
			$allpersonal_information = $all['user'];
		}else{
			$funcFromAdmin = false;
			$allpersonal_information = $all['user']['personal_information'];
		}
		$id = $allpersonal_information['id'];
		unset($all['personal_information']);	
		$param = User::find($id);
		if($param){		
				$param->id = $id;	
		}else{
			$param = new User();
		}
		$param->type       = $allpersonal_information['type'];
		$param->subtype    = $allpersonal_information['subtype'];
		$param->email      = $allpersonal_information['email'];
		
		$param->gender = $allpersonal_information['gender'];
		$param->martial_status = $allpersonal_information['martial_status'];
		$param->education_status = $allpersonal_information['education_status'];
		
		//$param->password_new = Input::get('password_new');
		$param->first_name = $allpersonal_information['first_name'];
		$param->last_name  = $allpersonal_information['last_name'];
		$param->street_1   = $allpersonal_information['street_1'];
		
		$param->city 	   = $allpersonal_information['city'];
		$param->state      = $allpersonal_information['state'];
		$param->zipcode    = $allpersonal_information['zipcode'];
		$param->country    = $allpersonal_information['country'];
		$param->phone_1    = $allpersonal_information['phone_1'];
		
		$param->mobile     = $allpersonal_information['mobile'];
		
		$param->date_of_birth = new DateTime($allpersonal_information['date_of_birth']);
		$param->date_of_birth->format('Y-m-d');
		$param->last_login = new DateTime('now');
		
		$param->registration   = $allpersonal_information['registration'];
		$param->send_newsletters  = $allpersonal_information['send_newsletters'];
		$param->save();
		unset($all['user']['personal_information']);
		if($funcFromAdmin){
			return Response::json('function from admin');die;
		}
		$update = null;
		foreach($all['user'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}
		$userId = $param->id;
		unset($obj['files']);
			foreach($obj as $docParamName => $docParamVals) {
			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->pluck('id');
			$iterableCount = 0;
			foreach($docParamVals as $param => $props) {
			
				if(is_int($param)) {
					foreach($props as $propKey => $propVal) {
						if(isset($propVal['paramValue'])){
							$paramValue = $propVal['paramValue'];
						}else{dd($props);}
					$paramName  = $propVal['paramName'];
					$iterable = $param;
					
					$param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->pluck('id');
					
						if ($param_id) {
							//checking where the values come from? from param_value? or from short/long?
							$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
							
							// if($iterable){
								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$userId)->pluck('id');
								if(!$existsId) {
									$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$userId)->pluck('id');
								}
							// }else{
								// $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',NULL)->where('ref_id',$userId)->pluck('id');
							// }
							
							
							
							
							if($existsId) {
							
								if(!$value_ref) {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);	
								} else {				
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);			
								}
							}else {
								if(!$value_ref) {						
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);	
								} else {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
								}
							}
						}
					}			
				}else if(!is_int($param)){
					
					$paramValue = $props['paramValue'];
					$param_id = DB::table('param')->where('name',  $param)->where('doc_param_id', $doc_param_id)->pluck('id');
					

					$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
					$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$userId)->pluck('id');
					if($existsId) {
						if(!$value_ref) {							
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);						
						} else {
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);	
						}
					} else {
						if(!$value_ref) {						
							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);	
						} else {
							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$userId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
						}						
					}
				}
		$iterableCount ++;
			}	
		}
		return Response::json($obj);
	}


// public function store()
	// {
		// $all = Input::all();
		// if(isset($all['from']) && $all['from'] == 'tables'){
			// $funcFromAdmin = true;
			// $allpersonal_information = $all['user'];
		// }else{
			// $funcFromAdmin = false;
			// $allpersonal_information = $all['user']['personal_information'];
		// }
		// $id = $allpersonal_information['id'];
		// unset($all['personal_information']);	
		// $param = User::find($id);
		// if($param){		
				// $param->id = $id;	
		// }else{
			// $param = new User();
		// }
		// $param->type       = $allpersonal_information['type'];
		// $param->subtype    = $allpersonal_information['subtype'];
		// $param->email      = $allpersonal_information['email'];
// 		
		// //$param->password_new = Input::get('password_new');
		// $param->first_name = $allpersonal_information['first_name'];
		// $param->last_name  = $allpersonal_information['last_name'];
		// $param->street_1   = $allpersonal_information['street_1'];
		// $param->street_2   = $allpersonal_information['street_2'];
		// $param->city 	   = $allpersonal_information['city'];
		// $param->state      = $allpersonal_information['state'];
		// $param->zipcode    = $allpersonal_information['zipcode'];
		// $param->country    = $allpersonal_information['country'];
		// $param->phone_1    = $allpersonal_information['phone_1'];
		// $param->phone_2    = $allpersonal_information['phone_2'];
		// $param->mobile     = $allpersonal_information['mobile'];
// 		
		// $param->date_of_birth = new DateTime($allpersonal_information['date_of_birth']);
		// $param->date_of_birth->format('Y-m-d');
		// $param->last_login = new DateTime('now');
// 		
		// $param->registration   = $allpersonal_information['registration'];
		// $param->send_newsletters  = $allpersonal_information['send_newsletters'];
		// $param->save();
		// unset($all['user']['personal_information']);
		// if($funcFromAdmin){
			// return Response::json('function from admin');die;
		// }
		// $update = null;
		// foreach($all['user'] as $doc_param => $param_object){
			// foreach ($param_object as $param_key => $param_value) {
				// $obj[$doc_param][$param_key] = $param_value;
			// }
		// }
		// unset($obj['files']);
		// foreach($obj as $doc_param => $values) {
			// $doc_param_id = DB::table('doc_param')->where('name', $doc_param)->where('doc_type_id', 1)->pluck('id');			
			// $iterableCount = 0;
			// foreach ($values as $param_name => $param_value) {
				// $param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');		
				// if(is_array($param_value)) {
					// $iterable = $param_value;
					// foreach($iterable as $m => $n) {	
						// $param_id = DB::table('param')->where('name', $m)->where('doc_param_id', $doc_param_id)->pluck('id');
						// if ($param_id) {
							// $value_ref = DB::table('param_value')->where('value', $n)->pluck('id');
							// $existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$param->id)->where('iteration',$iterableCount)->pluck('id');
							// if($existsId) {
// 								
								// if(!$value_ref) {
									// DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$n,'value_long'=>NULL]);
								// } else {
									// DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								// }
							// }else {
								// if(!$value_ref) {						
									// DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$n,'value_long'=>NULL]);	
								// } else {
									// DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
								// }
							// }
						// }
					// }	
				// } elseif (!is_array($param_value)) {
// 
					// if ($param_id) {
						// $value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');
						// $existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$param->id)->pluck('id');
						// if($existsId) {						
							// if(!$value_ref) {						
									// DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$param_value,'value_long'=>NULL]);	
							// } else {
									// DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
							// }
						// }else {
							// if(!$value_ref) {						
								// DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$param_value,'value_long'=>NULL]);	
							// } else {
								// DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
							// }
						// }	
					// }	
				// }		
				// $iterableCount ++;
			// }
		// }
		// return Response::json($obj);
	// }
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		
		
		$user = array();
		$userpersonal_information = User::find($id);
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
										   param.name AS paramName, 
										   param.slug AS slug,
										   param_type.name AS inputType,
										   doc_param.name AS docParamName 
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id 
										   LEFT JOIN param_type ON param.type_id = param_type.id
										   WHERE doc_type_id = 1 
										   AND type_user.id = ".$id));
		
		
		
		
		$user['personal_information'] = $userpersonal_information['original'];
		// foreach($userpersonal_information['original'] as $key => $val) {
// 			
// // 				
			// $user['personal_information'][$key]['paramName'] = $key;		
			// $user['personal_information'][$key]['paramValue'] = $val;
		// }
// 		
// 		
// 		
		
		foreach($params as $k=>$v) {
			$iteration    = $v->iteration;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->inputType;
			$slug = $v->slug;
			if($v->value_ref == null) {
				$value = $v->value_short;
			}else{
				$value = $v->value;
			}
			
			if($iteration !== NULL) {
								
									
								
						
						
					
			
				$user[$docParamName][$iteration][$paramName]['paramName'] = $paramName;		
				$user[$docParamName][$iteration][$paramName]['slug'] = $slug;
				$user[$docParamName][$iteration][$paramName]['paramValue'] = $value;
				$user[$docParamName][$iteration][$paramName]['inputType'] = $inputType;
							
				//$user[$docParamName][$iteration][$paramName] = $value;	
				
			
			
			}elseif($iteration == NULL) {
							
						
					
								
							
				$user[$docParamName][$paramName]['paramName'] = $paramName;		
				$user[$docParamName][$paramName]['slug'] = $slug;
				$user[$docParamName][$paramName]['paramValue'] = $value;
				$user[$docParamName][$paramName]['inputType'] = $inputType;
							
					
				//$user[$docParamName][$paramName] = $value;			
					
			}
		
		}		
		
		
		
		
		
		
		
		// foreach($params as $k=>$v) {
			// $iteration    = $v->iteration;
			// $docParamName = $v->docParamName;
			// $paramName = $v->paramName;
			// $inputType = $v->inputType;
// 		
			// if($v->value_ref == null) {
				// $value = $v->value_short;
			// }else{
				// $value = $v->value;
			// }
// 			
			// if($iteration !== NULL) {		
				// $user[$docParamName][$iteration][$paramName] = $value;		
			// }elseif($iteration == NULL) {
				// $user[$docParamName][$paramName] = $value;			
			// }
// 		
		// }		
	
		return Response::json($user);
	}
	
	
	public function getProfilePic()
	{
		$param_id =  DB::table('param')->where('name', 'profile_pic')->pluck('id');										 
		$profilePic =  DB::table('sys_param_values')->where('ref_id',$id)
													->where('param_id',$param_id)->first();
		return Response::json($profilePic);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);	
		return Response::json($id);
	}

}
