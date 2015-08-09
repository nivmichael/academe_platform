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
		->where('user_id',Auth::user()->id)
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
	
		foreach($obj as $docParamName => $docParamVals) {
			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 2)->pluck('id');
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
				
							// if($iterable){
								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$post->id)->pluck('id');
							// }else{
								// $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',NULL)->where('ref_id',$post->id)->pluck('id');
							// }
// 							
							
							
							
							if($existsId) {
							
								if(!$value_ref) {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);	
								} else {				
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);			
								}
							}else {
								if(!$value_ref) {						
									DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);	
								} else {
									DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
								}
							}
						}
					}			
				}else if(!is_int($param)){
					
					$paramValue = $props['paramValue'];
					$param_id = DB::table('param')->where('name', $param)->where('doc_param_id', $doc_param_id)->pluck('id');
					

					$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
					$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$post->id)->pluck('id');
					if($existsId) {
						if(!$value_ref) {							
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);						
						} else {
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);	
						}
					} else {
						if(!$value_ref) {						
							DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);	
						} else {
							DB::table('sys_param_values')->insert(['doc_type'=>2,'ref_id'=>$post->id,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);		
						}						
					}
				}
		$iterableCount ++;
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
											   param_type.name AS paramType,
											   doc_param.name AS docParamName
											   FROM	param 
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id 
											   LEFT JOIN param_type ON param.type_id = param_type.id
											   WHERE doc_type_id = 2 AND authorized = 1"));

		$postInfo = Schema::getColumnListing('type_post');
		
		$postInfoKeys = array_flip($postInfo);
		foreach ($postInfoKeys as $key => $value) {
			$postInfoKeys[$key] = '';
		}
				
		

		foreach($params as $k=>$v) {
			$paramName = $v->paramName;	
			$docParamName = $v->docParamName;
			//$value = $v->type_id;	
			$inputType = $v->paramType;
			
			//$post[$v->docParamName][$k][$paramName] = $v->value = '';
			
			$post[$docParamName][$paramName]['paramName'] = $paramName;		
			$post[$docParamName][$paramName]['paramValue'] = '';
			$post[$docParamName][$paramName]['inputType'] = $inputType;
		
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
										   param_type.name AS paramType,
										   param_value.value AS paramValue,
										   doc_param.name AS docParamName 
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_post ON sys_param_values.ref_id = type_post.id  
										   LEFT JOIN param_type ON param.type_id = param_type.id
										   WHERE doc_type_id = 2 
										   AND type_post.id = ".$id));
		
		$isMultiple = false;
		$post['postInfo'] = $postInfo;
		foreach($params as $k=>$v) {
			
			
		
			$iteration    = $v->iteration;
			
			$docParamName = $v->docParamName;
			$paramName    = $v->paramName;
			$inputType    = $v->paramType;
			$paramValue = $v->paramValue;
		
			if($v->value_ref == null) {
				$value = $v->value_short;
			} else {
				$value = $v->value;
			}
		
			if($iteration !== NULL) {
				$post[$docParamName][$iteration][$paramName]['paramName'] = $paramName;		
				$post[$docParamName][$iteration][$paramName]['paramValue'] = $value;
				$post[$docParamName][$iteration][$paramName]['inputType'] = $inputType;
		
				//$post[$docParamName][$iteration][$paramName] = $value;
				
		
			}elseif($iteration == NULL) {
												
				$post[$docParamName][$paramName]['paramName'] = $paramName;		
				$post[$docParamName][$paramName]['paramValue'] = $value;
				$post[$docParamName][$paramName]['inputType'] = $inputType;
								
										
									
								
							
						
					
				//$post[$docParamName][$paramName] = $value;
			
			}
			
			
		}	
		//$test = array_values($post[$docParamName]);
	//	$post[$docParamName] = array_values($post[$docParamName]);
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