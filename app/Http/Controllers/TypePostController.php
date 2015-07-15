<?php namespace App\Http\Controllers;

use DB;
use Response;
use Input;
use DateTime;
use App\User;
use App\Post;
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
				
				$postInfo = Post::find($postParams->id);	
				$post['postInfo'] = $postInfo;
			}
				// $logo_param_id = DB::table('param')->where('name','company_logo')->pluck('id');
				// $company_logo  = DB::table('sys_param_values')->where('id',$logo_param_id)->get();
				 $postsArr[] = $post;
		}
		//var_dump($company_logo);die;



		return Response::json($postsArr);
	}
	
	public function savePost()
	{
		
		
		
		
		
		$all = Input::all();
		$allPostInfo = $all['post']['postInfo'];
		$id = $allPostInfo['id'];
		$userId = Auth::user()->id;		
	
		
		
	
		$post = Post::find($id);
		if($post){		
				$post->id = $id;	
		}else{
			$post = new Post();
		}
		
		
		
	
		$post->title = $all['post']['postInfo']['title'];
		$post->user_id = $userId;
		$post->description_short = $all['post']['postInfo']['description_short'];
		$post->description = $all['post']['postInfo']['description'];
		$post->authorized = $all['post']['postInfo']['authorized'];
		$post->save(); 
	
		
		
		unset($all['post']['postInfo']);
		
		
		
			
		
		foreach($all['post'] as $doc_param => $param_object){
			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}
		
		$param_id = null;
		
		foreach($obj as $doc_param => $values) {
			$doc_param_id = DB::table('doc_param')->where('name', $doc_param)->where('doc_type_id', 2)->pluck('id');
			
			foreach ($values as $param_name => $param_value) {
				$param_id = DB::table('param')->where('name', $param_name)->where('doc_param_id', $doc_param_id)->pluck('id');

				if(is_array($param_value)) {
					$iterable = $param_value;
					
					foreach($iterable as $m => $n) {
						$param_id = DB::table('param')->where('name', $m)->where('doc_param_id', $doc_param_id)->pluck('id');

						if ($param_id) {
							//checking where the values come from? from param_value? or from short/long?
							$value_ref = DB::table('param_value')->where('value', $n)->pluck('id');
							
							if(!$value_ref) {
								if($param_value) {
									$value_ref = $n;
								} else {
									$value_ref = NULL;
								}
							}
						}

						$test =	DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);
					}
				} elseif ($param_id) {
					//checking where the values come from? from param_value? or from short/long?
					$value_ref = DB::table('param_value')->where('value', $param_value)->pluck('id');
					
					if(!$value_ref) {
						if($param_value){
							$value_ref = $param_value;
						} else {
							$value_ref = NULL;
						}
					}
				}

				DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$value_ref,'value_long'=>NULL]);	
			}
		}

		return Response::json($obj);
	}
	
	public function jobPostColumnIndex()
	{	
		$postInfo = new stdClass();
		$post = array();	
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.name AS paramName, 
											   doc_param.name AS docParamName 
											   FROM	param 
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id 
											   WHERE doc_type_id = 2 AND authorized = 1"));

		$postInfo = Schema::getColumnListing('type_post');
		
		$postInfoKeys = array_flip($postInfo);
		foreach ($postInfoKeys as $key => $value) {
			$postInfoKeys[$key] = '';
		}
				
		

		foreach($params as $k=>$v) {
			$paramName = $v->paramName;		
			$post[$v->docParamName][$paramName] = $v->value = '';
		}	
		// foreach($postInfo as $key=>$value) {
			// if($value){
				// $postInfo[$value] = '';				
			// }
// 		
		 $post['postInfo'] = $postInfoKeys;
		 
		// }
		
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
		
		$post = array();
		$postInfo = Post::find($id);
		$params =  DB::select( DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_post.*,
										   param.name AS paramName, 
										   doc_param.name AS docParamName 
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_post ON sys_param_values.ref_id = type_post.id WHERE type_post.id = ".$id));
		
	
		$post['postInfo'] = $postInfo;
		foreach($params as $k=>$v) {
			$docParamName = $v->docParamName;
			$paramName    = $v->paramName;
			if($v->value_ref == null) {
				$value = $v->value_short;
			}else{
				$value = $v->value;
			}
			if($paramName){
				print_r($paramName);
			}
			$post[$docParamName][$paramName] = $value;
			
		}	
		
		
		
		
		
			
		return Response::json($post);
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
