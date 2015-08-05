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
	
	public function columnIndexJobSeeker()
	{	
		$personalInfo = new stdClass();
		$user = array();	
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.name AS paramName, 
											   doc_param.name AS docParamName 
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
											   WHERE doc_type_id = 1 
											   AND doc_param.doc_sub_type = 'jobSeeker'
											   AND authorized = 1"));
		if(!Auth::user()){
			$userPersonalInfo = Schema::getColumnListing('type_user');
			$userPersonalInfo = (object)$userPersonalInfo;			
			foreach($userPersonalInfo as $key=>$value) {
				$personalInfo->$value = '';
			}
		}else {		
			$id = Auth::user()->id;		
			$personalInfo = User::find($id);		
		}
		$user['personalInfo'] = $personalInfo;
		// $user['personalInfo']->password_confirmation = '';
		foreach($params as $k=>$v) {
			$paramName = $v->paramName;		
			$user[$v->docParamName][$paramName] = $v->value = '';
		}	
		
		
				
		return Response::json($user);
	}
	
	public function columnIndexEmployer()
	{	
		$personalInfo = new stdClass();
		$user = array();	
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.name AS paramName, 
											   doc_param.name AS docParamName 
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
											   WHERE doc_type_id = 1 
											   AND doc_param.doc_sub_type = 'employer'
											   AND authorized = 1"));
		if(!Auth::user()){
			$userPersonalInfo = Schema::getColumnListing('type_user');
			$userPersonalInfo = (object)$userPersonalInfo;			
			foreach($userPersonalInfo as $key=>$value) {
				$personalInfo->$value = '';
			}
		}else {		
			$id = Auth::user()->id;		
			$personalInfo = User::find($id);		
		}
		$user['personalInfo'] = $personalInfo;
		// $user['personalInfo']->password_confirmation = '';
		foreach($params as $k=>$v) {
			$paramName = $v->paramName;		
			$user[$v->docParamName][$paramName] = $v->value = '';
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
			$allPersonalInfo = $all['user'];
		}else{
			$funcFromAdmin = false;
			$allPersonalInfo = $all['user']['personalInfo'];
		}
		$id = $allPersonalInfo['id'];
		unset($all['personalInfo']);	
		$param = User::find($id);
		if($param){		
				$param->id = $id;	
		}else{
			$param = new User();
		}
		$param->type       = $allPersonalInfo['type'];
		$param->subtype    = $allPersonalInfo['subtype'];
		$param->email      = $allPersonalInfo['email'];
		
		//$param->password_new = Input::get('password_new');
		$param->first_name = $allPersonalInfo['first_name'];
		$param->last_name  = $allPersonalInfo['last_name'];
		$param->street_1   = $allPersonalInfo['street_1'];
		$param->street_2   = $allPersonalInfo['street_2'];
		$param->city 	   = $allPersonalInfo['city'];
		$param->state      = $allPersonalInfo['state'];
		$param->zipcode    = $allPersonalInfo['zipcode'];
		$param->country    = $allPersonalInfo['country'];
		$param->phone_1    = $allPersonalInfo['phone_1'];
		$param->phone_2    = $allPersonalInfo['phone_2'];
		$param->mobile     = $allPersonalInfo['mobile'];
		
		$param->date_of_birth = new DateTime($allPersonalInfo['date_of_birth']);
		$param->date_of_birth->format('Y-m-d');
		$param->last_login = new DateTime('now');
		
		$param->registration   = $allPersonalInfo['registration'];
		$param->send_newsletters  = $allPersonalInfo['send_newsletters'];
		$param->save();
		unset($all['user']['personalInfo']);
		if($funcFromAdmin){
			return Response::json('function from admin');die;
		}
		$update = null;
		foreach($all['user'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}
		unset($obj['files']);
		foreach($obj as $doc_param => $values) {
			$doc_param_id = DB::table('doc_param')->where('name', $doc_param)->where('doc_type_id', 1)->pluck('id');			
			$iterableCount = 0;
			foreach ($values as $param_name => $param_value) {
				$param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');		
				if(is_array($param_value)) {
					$iterable = $param_value;
					foreach($iterable as $m => $n) {	
						$param_id = DB::table('param')->where('name', $m)->where('doc_param_id', $doc_param_id)->pluck('id');
						if ($param_id) {
							$value_ref = DB::table('param_value')->where('value', $n)->pluck('id');
							$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$param->id)->where('iteration',$iterableCount)->pluck('id');
							if($existsId) {
								
								if(!$value_ref) {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$n,'value_long'=>NULL]);
								} else {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								}
							}else {
								if(!$value_ref) {						
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$n,'value_long'=>NULL]);	
								} else {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
								}
							}
						}
					}	
				} elseif (!is_array($param_value)) {

					if ($param_id) {
						$value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');
						$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$param->id)->pluck('id');
						if($existsId) {						
							if(!$value_ref) {						
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$param_value,'value_long'=>NULL]);	
							} else {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
							}
						}else {
							if(!$value_ref) {						
								DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$param_value,'value_long'=>NULL]);	
							} else {
								DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$param->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
							}
						}	
					}	
				}		
				$iterableCount ++;
			}
		}
		return Response::json($obj);
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		
		
		
		$user = array();
		$userPersonalInfo = User::find($id);
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
										   param.name AS paramName, 
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
		
		
		$user['personalInfo'] = $userPersonalInfo;
		
		
		
		
		
		foreach($params as $k=>$v) {
			$iteration    = $v->iteration;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->inputType;
		
			if($v->value_ref == null) {
				$value = $v->value_short;
			}else{
				$value = $v->value;
			}
			
			if($iteration !== NULL) {
								
									
								
						
						
					
			
				$user[$docParamName][$iteration][$k]['paramName'] = $paramName;		
				$user[$docParamName][$iteration][$k]['paramValue'] = $value;
				$user[$docParamName][$iteration][$k]['inputType'] = $inputType;
							
				//$user[$docParamName][$iteration][$paramName] = $value;	
				
			
			
			}elseif($iteration == NULL) {
							
						
					
								
							
				$user[$docParamName]['paramName'] = $paramName;		
				$user[$docParamName]['paramValue'] = $value;
				$user[$docParamName]['inputType'] = $inputType;
							
					
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