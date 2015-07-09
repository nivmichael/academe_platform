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
		$post = array();
		$postsArr=array();
		$posts = DB::table('type_post')
		->get();		
		
		foreach($posts as $key=>$postParams){
			$sys_param_values = DB::table('sys_param_values')->where('ref_id','=',$postParams->id)->get();			
			foreach ($sys_param_values as $value) {			
				$paramId      = $value->param_id;
	 			$value 	      = $value->value_short;
				$paramName    = DB::table('param')->where('id','=',$paramId)->pluck('name');
				$docParamId   = DB::table('param')->where('name','=',$paramName)->pluck('doc_param_id');
				///print_r($docParamId);die;
				$docParamName   = DB::table('doc_param')->where('id','=',$docParamId)->pluck('name');
				$post[$docParamName][$paramName] = $value;
				
			}
				// $logo_param_id = DB::table('param')->where('name','company_logo')->pluck('id');
				// $company_logo  = DB::table('sys_param_values')->where('id',$logo_param_id)->get();
				// $postsArr[] = $post;
		}
		//var_dump($company_logo);die;



		return Response::json($postsArr);
	}
	
	public function savePost()
	{
		$userId = Auth::user()->id;			
		$all = Input::all();
		foreach($all['post'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}

		foreach($obj as $doc_param => $values) {
			$doc_param_id = DB::table('doc_param')->where('name', $doc_param)->where('doc_type_id', 2)->pluck('id');
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
							$postId = DB::table('type_post')->insertGetId(['user_id'=>$userId,'title'=>'titlex','description_short'=>'desc_short','authorized'=>1]);								
									  DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$postId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
					}
				}
			}
		}
		return Response::json($obj);
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
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id 
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
