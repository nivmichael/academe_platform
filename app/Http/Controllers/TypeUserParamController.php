<?php namespace App\Http\Controllers;

use DB;
use PDO;
use Config;
use Response;
use Input;
use Schema;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TypeUserParams;

use Illuminate\Http\Request;

class TypeUserParamController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Config::set('database.fetch', PDO::FETCH_ASSOC);
		$params = DB::table('type_user_params')
		->get();
	
		
	
		return $params;
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
		$param = TypeUserParams::find($id);
		if($param){
			$param->id = $id;	
		}else{
			$param = new TypeUserParams();
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
		TypeUserParams::destroy($id);	
		return Response::json($id);
	}

}
