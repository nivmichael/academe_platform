<?php namespace App\Http\Controllers;

use DB;
use stdClass;
use PDO;
use Response;
use Input;
use Schema;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Params;

use Illuminate\Http\Request;

class ParamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
			
		
		$columns = Schema::getColumnListing('type_user_params');
		$columns = (object) $columns;
		
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
		
		
		$id = Input::get('id');
		$param = Param::find($id);
		if($param){
			$param->id = $id;	
		}else{
			$param = new Param();
		}
		$name = Input::get('name');
		$param->p_name = $name;
		$param->save();
		return Response::json(array('param'=>$param,'id'=>$id));
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
		 
		// $param = TypeUserParams::find($id);
		// $param->p_name = '$name';
// 		
		// $param->save();
// 		
		// return Response::json(array('param'=>$param))		 ;
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
		Param::destroy($id);	
		return Response::json($id);
	}

}
