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

class TypePostController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	
		$users = DB::table('type_post')
		->get();		
		return Response::json($users);
	}
	
	public function savePost()
	{
		
		$all = Input::all();
		$personalInfo = $all['post']['personalInfo'];
	

		foreach($all['post'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}

		
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
						
						
					//	$update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_user_id', $personalInfo->id)->update(['value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
						//if(!$update) {
							
							DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_user_id', $personalInfo->id)->insert(['doc_type'=>2,'ref_user_id'=>$personalInfo->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
						// }
					// } else {
					
				
						//	$update = DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_user_id',  $personalInfo->id)->update(['value_ref'=>$value_ref,'value_short'=>null,'value_long'=>null]);
							//if(!$update) {
							DB::table('sys_param_values')->where('param_id', $param_id)->where('ref_user_id', $personalInfo->id)->insert(['doc_type'=>2,'ref_user_id'=>$personalInfo->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);	
						//}
					}
				}
			}
		}



		return Response::json($all);
	}
	
	public function jobPostColumnIndex()
	{	
		
		$post = array();	
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.name AS paramName, 
											   doc_param.name AS docParamName 
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_user_id = type_user.id 
											   WHERE doc_type_id = 2"));

		foreach($params as $k=>$v) {
			$paramName = $v->paramName;		
			$post[$v->docParamName][$paramName] = $v->value = '';
		}	
		
		
				
		return Response::json($post);
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
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
		//
	}

}
