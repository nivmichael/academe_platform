<?php namespace App\Http\Controllers;

use DB;
use stdClass;
use PDO;
use Response;
use Input;
use Schema;
use App\DocParam;
use App\Param;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DocParamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$params = DB::table('doc_param')
		->get();

		return Response::json($params);
	}
	
	public function columnIndex()
	{
		
		$columns = Schema::getColumnListing('doc_param');
		$columns = (object) $columns;
// 		
		// return Response::json(array($columns,$params));
		return Response::json($columns);
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
		$all = Input::all();
		$all = $all['user'];
		$id = $all['id'];
		$param = DocParam::find($id);
		if($param){
			$param->id = $id;	
		}else{
			$param = new DocParam();
		}
		$name = $all['name'];
		$slug = $all['slug'];
		$doc_type_id = $all['doc_type_id'];
		
		$param->name = $name;
		$param->slug = $slug;
		$param->doc_type_id = $doc_type_id;
		$param->save();
		
		return Response::json(array('param'=>$param,'id'=>$id));
	}
	
	
	// public function getCompanyParamInput($paramName) {
// 		
		// $param =new stdClass();
// 		
		// $paramTypeId = DB::table('param')->where('name',$paramName)->pluck('type_id');
		// $paramType   = DB::table('param_type')->where('id',$paramTypeId)->pluck('name');
// 		
		// $param->paramName = $paramName;
		// $param->paramValue= '';
		// $param->inputType = $paramType;
// 		
// 		
		// return Response::json($param);
	// }

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
		DocParam::destroy($id);	
		return Response::json($id);
	}

}
