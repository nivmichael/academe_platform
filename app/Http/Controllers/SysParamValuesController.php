<?php namespace App\Http\Controllers;


use DB;
use PDO;
use Response;
use Input;
use Schema;
use App\SysParamValues;
use App\Param;
use App\ParamValue;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SysParamValuesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$params = DB::table('sys_param_values')
		->get();
		return Response::json($params);
	}
	
	
	public function columnIndex()
	{
		
		$columns = Schema::getColumnListing('sys_param_values');
		$columns = (object) $columns;
// 		
		// return Response::json(array($columns,$params));
		return Response::json($columns);
	}
	
	// public function filtered()
	// {
		// $paramValue = DB::table('param_value');
		// $sysParamsValues = SysParamValues::where('param_id','=', )
		// return Response::json($sysParamsValues);
	// }
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
	
	public function saveParam()
	{
		$all = Input::all();
		$array = array();
		foreach($all as $key=>$value){
			$param = Param::where('name','=', $key)->first();
			$paramVal = ParamValue::where('value','=', $value)->first();
			$sysParamValue=SysParamValues::where('param_id','=',$param['id'])->first();
			$sysParamValue->value_ref = $paramVal['id'];
			$sysParamValue->save();
			$array[]=$sysParamValue;
		}
	 	//$sys_param_value = SysParamValues::find($param_id);
		
		return Response::json($array);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$all = Input::all();
		$param_id = $all['id'];
		$sys_param_value = SysParamValues::find($param_id);	 
		
		if(!$sys_param_value){
		
			$sys_param_value = new SysParamValues();
		}else{
				
			$sys_param_value->doc_type	  = $all['doc_type'];
			$sys_param_value->ref_user_id = $all['ref_user_id'];
			$sys_param_value->param_id	  = $all['param_id'];
			$sys_param_value->iteration   = $all['iteration'];
			$sys_param_value->value_short = $all['value_short'];
			$sys_param_value->value_long  = $all['value_long'];
			$sys_param_value->value_ref   = $all['value_ref'];
			// $sys_param_value->created_at   = $all['created_at'];
			// $sys_param_value->updated_at   = $all['updated_at'];
			//$sys_param_value->save();
		}
		$sys_param_value->save();

		return Response::json($param_id);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sysParamValues = SysParamValues::where('ref_user_id','=', $id)->get();
		
		return Response::json($sysParamValues);
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
		SysParamValues::destroy($id);	
		return Response::json($id);
	}

}
