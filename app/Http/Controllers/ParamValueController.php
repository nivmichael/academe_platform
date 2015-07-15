<?php namespace App\Http\Controllers;


use DB;
use PDO;
use Response;
use Input;
use Schema;
use App\ParamType;
use App\Param;
use App\ParamValue;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ParamValueController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$values = DB::table('param_value')
		->get();
		
		return Response::json($values);
	}
	
	public function columnIndex()
	{
		
		$columns = Schema::getColumnListing('param_value');
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
	  $array = array();	 
	  $paramValue=Input::all();
	  foreach($paramValue as $paramValueKey=>$paramValueValue){
	  	$value = Param::where('name','=',$paramValueKey)->first();	 		
	  	$array[$value['id']]=$paramValueValue;	 
	  }		 
	  $params=array();
	  foreach($array as $arrayKey=>$arrayValue){
	  	$param = ParamValue::find($all['id']);	 	
		if(!$param){			 	
			$param = new ParamValue();
	  	}
		$param->value = $all['value']; 
		$param->param_id = $all['param_id']; 
		
		$param->save();
		$params[]=$param;
	  }	
	  return Response::json($params);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$paramValue = ParamValue::find($id);
		
		return Response::json($paramValue);
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
		ParamValue::destroy($id);	
		return Response::json($id);
	}

}
