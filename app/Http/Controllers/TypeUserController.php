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
	//personalInfo //no dynamic parameters	
		
	
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
		if($funcFromAdmin){
			return Response::json('function from admin');die;
		}
		$update = null;
		// var_dump($all);die;
		foreach($all['user'] as $doc_param => $values) {
			$doc_param_id = DB::table('doc_param')->where('name', $docParam)->where('doc_type_id', 1)->where('doc_sub_type', $doc_sub_type)->pluck('id');	
			foreach ($values as $param_name => $param_value) {
				$param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');				
				if ($param_id) {
					//checking where the values come from? from param_value? or from short/long?
					$value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');					
					if(!$value_ref) {						
								$value_ref = $param_value;								
								$sys_param_id = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $id)->pluck('id');		
								if($param_value){
									$update = DB::table('sys_param_values')->where('id', $sys_param_id)->update(['value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
								}							
					} else {
							$update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_id', $id)->update(['value_ref'=>$value_ref,'value_short'=>null,'value_long'=>null]);
					}
				}
			}
		}
		return Response::json($param);
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
										   doc_param.name AS docParamName 
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id WHERE type_user.id = ".$id));
		
		
		$user['personalInfo'] = $userPersonalInfo;
		foreach($params as $k=>$v) {
			$iteration    = $v->iteration;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
		
		
			if($v->value_ref == null) {
				$value = $v->value_short;
			}else{
				$value = $v->value;
			}
			
			if($iteration) {
				//$user[$docParamName][] = array($paramName=>$value) ;
				$user[$docParamName][$iteration][$paramName] = $value;
			}elseif(!$iteration) {
				$user[$docParamName][$paramName] = $value;
			}
			
			
		}		
		//$param_id = DB::table('param')->where('name', 'company_logo')->pluck('id');										 
		
	//	$images  =  DB::table('sys_param_values')->where('ref_id',$id)
											//	 ->where('param_id',$param_id)
										//		 ->whereNotNull('value_short')->get();
// 		
		// $user['files']['gallery'] = $images;		
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