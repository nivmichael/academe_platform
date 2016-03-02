<?php namespace App\Http\Controllers;

use JWTAuth;
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
use App\Http\Controllers\TypePostController;
use Hash;
use Auth;
use App\Post;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;


class TypeUserController extends Controller
{



	protected $user;
	protected $posts;

	public function __construct(UserRepository $user, PostRepository $posts)
	{
		$this->middleware('jwt.auth', ['except' => ['columnIndexJobSeeker','columnIndexEmployer']]);
		$this->user = $user;
		$this->posts = $posts;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return response()->json([ 'user' => $this->user->all($request->user()),'posts'=> $this->posts->getAllPosts()]);
	}

	public function postsWithMatch(Request $request)
	{
		return response()->json([ 'user' => $this->user->all($request->user()),'posts'=> $this->posts->postsWithMatch($request->user())]);
	}

	public function forUser(Request $request)
	{
		return response()->json([ 'user' => $this->user->all($request->user()),'posts'=> $this->posts->forUser($request->user())]);
	}

	public function me(Request $request)
	{

		$id = $request->user()->id;
		$user = array();
		$userpersonal_information = User::find($id);
		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
										   param.slug AS slug,
											   param.id AS paramId,
											   param.name AS paramName,
											   param.position AS paramPosition,
											   param.param_parent_id AS paramParent,
											   doc_param.name AS docParamName,
											   param_type.name AS paramType,
											   doc_param.id AS docParamId
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
										   LEFT JOIN param_type ON param.type_id = param_type.id
										   WHERE doc_type_id = 1
										   AND type_user.id = " . $id));

		//return($params);
		$user['personal_information'] = $userpersonal_information['original'];

		foreach ($params as $k => $v) {
			$iteration = $v->iteration;
			$docParamId = $v->docParamId;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->paramType;
			$slug = $v->slug;
			$position = $v->position;
			$paramId = $v->paramId;
			$paramParent = $v->paramParent;

			if ($v->value_ref == null) {
				$value = $v->value_short;
			} else {
				$value = $v->value;
			}

			if ($iteration !== NULL) {


				$values = array();
				if ($inputType == 'checklist') {
					$value = explode('|', $value);
					foreach ($value as $key => $value) {
						//			$paramOptions[$key] = [];
//
//						$option['value'] = $value;
//						$option['text'] = $value;
//						$values[]  =$option;
						if ($value) {
							$values[] = $value;
						}
					}
				}
				if ($values) {
					$value = $values;
				}
				$user[$docParamName][$iteration]['docParamId'] = $docParamId;
				$user[$docParamName][$iteration][$paramId]['paramName'] = $paramName;
				$user[$docParamName][$iteration][$paramId]['paramId'] = $paramId;
				$user[$docParamName][$iteration][$paramId]['paramParentId'] = $paramParent;
				$user[$docParamName][$iteration][$paramId]['slug'] = $slug;
				$user[$docParamName][$iteration][$paramId]['paramValue'] = $value;
				$user[$docParamName][$iteration][$paramId]['inputType'] = $inputType;

			} elseif ($iteration == NULL) {
				$values = array();
				if ($inputType == 'checklist') {
					$value = explode('|', $value);
					foreach ($value as $key => $value) {
						if ($value) {
							$values[] = $value;
						}
					}
				}
				if ($values) {
					$value = $values;
				}
				$user[$docParamName]['docParamId'] = $docParamId;
				$user[$docParamName][$paramId]['paramName'] = $paramName;
				$user[$docParamName][$paramId]['paramId'] = $paramId;
				$user[$docParamName][$paramId]['paramParentId'] = $paramParent;
				$user[$docParamName][$paramId]['slug'] = $slug;
				$user[$docParamName][$paramId]['paramValue'] = $value;
				$user[$docParamName][$paramId]['inputType'] = $inputType;

			}
		}
		return Response::json($user);
	}
	public function updateUser(Request $request)
	{
		$all = request()->all();
		if (isset($all['from']) && $all['from'] == 'tables') {
			$funcFromAdmin = true;
			$allpersonal_information = $all['user'];
		} else {
			$funcFromAdmin = false;
			$allpersonal_information = $all['personal_information'];
		}
		$id = $allpersonal_information['id'];
		unset($all['personal_information']);
		$param = User::find($id);
		$userPI = $param;
		if ($param) {
			$param->id = $id;
		} else {
			$param = new User();
		}
		$param->type = $allpersonal_information['type'];
		$param->subtype = $allpersonal_information['subtype'];
		$param->email = $allpersonal_information['email'];
		$param->gender = $allpersonal_information['gender'];
		$param->martial_status = $allpersonal_information['martial_status'];
		$param->education_status = $allpersonal_information['education_status'];
		$param->first_name = $allpersonal_information['first_name'];
		$param->last_name = $allpersonal_information['last_name'];
		$param->street_1 = $allpersonal_information['street_1'];
		$param->city = $allpersonal_information['city'];
		$param->state = $allpersonal_information['state'];
		$param->zipcode = $allpersonal_information['zipcode'];
		$param->country = $allpersonal_information['country'];
		$param->phone_1 = $allpersonal_information['phone_1'];
		$param->mobile = $allpersonal_information['mobile'];
//		$param->date_of_birth = new DateTime($allpersonal_information['date_of_birth']);
//		$param->date_of_birth->format('Y-m-d');
		$param->last_login = new DateTime('now');
		$param->registration = $allpersonal_information['registration'];
		$param->send_newsletters = $allpersonal_information['send_newsletters'];
		$param->save();

		unset($all['user']['personal_information']);
		if ($funcFromAdmin) {
			return Response::json('function from admin');
			die;
		}
		$update = null;
		$authId = $param->id;
		foreach($all as $doc_param => $param_object){

			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}

		foreach($obj as $docParamName => $docParamVals) {
			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->pluck('id');
			$iterableCount = 0;
			foreach($docParamVals as $param => $props) {
				//dd(array_key_exists ( 'docParamId' , $docParamVals ));
				//dd($docParamVals);
				if(!array_key_exists ( 'docParamId' , $docParamVals )) {
					//print_r('array');
					foreach($props as $propKey => $propVal) {
						if(isset($propVal['paramValue'])){

						}else{
							//print_r($propKey);
						}
						if($propVal['paramValue']){


							$paramValue = $propVal['paramValue'];
							if(is_array($paramValue)) {
								$paramValue = implode('|',$paramValue);
								//print_r($paramValue);
							}

						}else{
							$paramValue='';
						};
						$paramName  = $propVal['paramName'];
						$iterable = $param;

						$param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->value('id');

						if ($param_id) {
							//checking where the values come from? from param_value? or from short/long?
							$value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');

							$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$authId)->value('id');
							if(!$existsId) {
								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$authId)->value('id');
							}



							if($existsId) {

								if(!$value_ref) {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
								} else {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								}
							}else {
								if(!$value_ref) {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
								} else {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								}
							}
						}

					}
				}else if(array_key_exists ( 'docParamId' , $docParamVals )){

					//print_r('single');
					if(isset($props['paramValue'])){
						$paramValue = $props['paramValue'];
					}else{
						//print_r('here');
						$paramValue= '';
					}


					if(is_array($paramValue)) {
						$paramValue = implode('|',$paramValue);

					}
					$param_id = $param;
					//$param_id = DB::table('param')->where('id',  $param)->where('doc_param_id', $doc_param_id)->value('id');
					if($param_id == null) {
						dd('some thing wrong with param: '.$param);
					}

					$value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');
					$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$authId)->value('id');
					if($existsId) {
						if(!$value_ref) {
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
						} else {
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
						}
					} else {
						if(!$value_ref) {
							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
						} else {
							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
						}
					}
				}
				$iterableCount ++;
			}
		}
		$obj = array('personal_information' => $userPI) + $obj;
		//$obj['personal_information'] = $userPI;

//		return response()->json($obj);


		return response()->json([ 'user' => $obj,'posts'=> $this->posts->getAllPosts() ]);
	}


//getGridableObj
//	public function index()
//	{
//		$jobseekerColumns = [];
//		$employerColumns  = [];
//		$usersObj = [];
//		$users = DB::table('type_user')->get();
//		foreach($users as $user){
//
//
//			$userpersonal_information = User::find($user->id);
//			$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
//										   param.slug AS slug,
//											   param.id AS paramId,
//											   param.name AS paramName,
//											   param.position AS paramPosition,
//											   param.param_parent_id AS paramParent,
//											   doc_param.name AS docParamName,
//											   param_type.name AS paramType,
//											   doc_param.id AS docParamId
//										   FROM	param
//										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
//										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
//										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
//										   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
//										   LEFT JOIN param_type ON param.type_id = param_type.id
//										   WHERE doc_type_id = 1
//										   AND type_user.id = " .$user->id));
//			$user = array();
//			//return($params);
//			$user['personal_information'] = $userpersonal_information['original'];
//
//			foreach ($params as $k => $v) {
//				$iteration = $v->iteration;
//				$docParamId = $v->docParamId;
//				$docParamName = $v->docParamName;
//				$paramName = $v->paramName;
//				$inputType = $v->paramType;
//				$slug = $v->slug;
//				$position = $v->position;
//				$paramId = $v->paramId;
//				$paramParent = $v->paramParent;
//
//				if ($v->value_ref == null) {
//					$value = $v->value_short;
//				} else {
//					$value = $v->value;
//				}
//
//				if ($iteration !== NULL) {
//
//
//					$values = array();
//					if ($inputType == 'checklist') {
//						$value = explode('|', $value);
//						foreach ($value as $key => $value) {
//							//			$paramOptions[$key] = [];
////
////						$option['value'] = $value;
////						$option['text'] = $value;
////						$values[]  =$option;
//							if ($value) {
//								$values[] = $value;
//							}
//						}
//					}
//					if ($values) {
//						$value = $values;
//					}
//
//
//					$user[$docParamName][$iteration]['docParamId'] = $docParamId;
//					$user[$docParamName][$iteration][$paramId]['paramName'] = $paramName;
//					$user[$docParamName][$iteration][$paramId]['paramId'] = $paramId;
//					$user[$docParamName][$iteration][$paramId]['paramParentId'] = $paramParent;
//					$user[$docParamName][$iteration][$paramId]['slug'] = $slug;
//					$user[$docParamName][$iteration][$paramId]['paramValue'] = $value;
//					$user[$docParamName][$iteration][$paramId]['inputType'] = $inputType;
//				} elseif ($iteration == NULL) {
//
//					$values = array();
//					if ($inputType == 'checklist') {
//						$value = explode('|', $value);
//						foreach ($value as $key => $value) {
//
//							if ($value) {
//								$values[] = $value;
//							}
//						}
//					}
//					if ($values) {
//						$value = $values;
//					}
////					$user[$docParamName]['docParamId'] = $docParamId;
////					$user[$docParamName][$paramId]['paramName'] = $paramName;
////					$user[$docParamName][$paramId]['paramId'] = $paramId;
////					$user[$docParamName][$paramId]['paramParentId'] = $paramParent;
////					$user[$docParamName][$paramId]['slug'] = $slug;
////					$user[$docParamName][$paramId]['paramValue'] = $value;
////					$user[$docParamName][$paramId]['inputType'] = $inputType;
//
//
//
//
//					$user[$paramName]['paramName']= $paramName;
//					$user[$paramName]['docParamId']= $docParamId;
//					$user[$paramName]['paramId']= $paramId;
//					$user[$paramName]['paramParentId']= $paramParent;
//					$user[$paramName]['inputType']= $inputType;
//					$user[$paramName]['paramValue']= $value;
//
//					if($user['personal_information']['subtype'] == 'jobseeker'){
//						$column= [];
//						$column['title'] = $paramName;
//						$column['type'] = $inputType;
//						$column['docParamName'] = $docParamName;
//						$column['checked'] = true;;
//						$jobseekerColumns[]= $column;
//
//
//					}elseif($user['personal_information']['subtype'] == 'employer'){
//						$column= [];
//						$column['title'] = $paramName;
//						$column['type'] = $inputType;
//						$column['checked'] = true;;
//						$column['docParamName'] = $docParamName;
//						$employerColumns[] = $column;
//
//					}
////					$user[$paramName] = $value;
//
//				}
//
//
//			}
//			foreach($user['personal_information'] as $userParam => $val){
//				$user[$userParam]['paramName']    = $userParam;
//				$user[$userParam]['docParamId']   = '';
//				$user[$userParam]['paramId']      = '';
//				$user[$userParam]['paramParentId']= '';
//
//				$user[$userParam]['paramValue']   = $val;
//
//				$column= [];
//				$column['title'] = $userParam;
//				$column['type'] = $inputType;
//				$column['checked'] = true;;
//				$column['docParamName'] = 'personal_information';
//				if($user['personal_information']['subtype'] == 'jobseeker'){
//					$jobseekerColumns[]= $column;
//				}elseif($user['personal_information']['subtype'] == 'employer'){
//					$employerColumns[] = $column;
//				}
//			}
//			unset($user['personal_information']);
//			$usersObj[] = $user;
//
//		}
//		return Response::json(array('users'=>$usersObj, 'jobseekerColumns'=>$jobseekerColumns , 'employerColumns'=>$employerColumns));
//	}
	public function getSingleDimensionColumnsByType($subtype)
	{
		return Response::json($subtype);
	}

	public function columnIndex()
	{

		$columns = Schema::getColumnListing('type_user');
		$columns = (object)$columns;
// 		
		// return Response::json(array($columns,$params));
		return Response::json($columns);
	}

	public function columnIndexJobSeeker()
	{


		$personal_information = new stdClass();
		$user = array();
		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.slug AS slug,
											   param.id AS paramId,
											   param.name AS paramName,
											   param.position AS paramPosition,
											   param.param_parent_id AS paramParent,
											   doc_param.name AS docParamName,
											   param_type.name AS paramType,
											   doc_param.id AS docParamId
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
											   LEFT JOIN param_type ON param.type_id = param_type.id
											   WHERE doc_type_id = 1 
											   AND doc_param.doc_sub_type = 'jobSeeker'
											   AND authorized = 1"));
		if (!Auth::user()) {
			$userpersonal_information = Schema::getColumnListing('type_user');
			$userpersonal_information = (object)$userpersonal_information;
			foreach ($userpersonal_information as $key => $value) {
				$personal_information->$value = '';
			}
		} else {
			$id = Auth::user()->id;
			$personal_information = User::find($id);
		}
		$user['personal_information'] = $personal_information;
		// $user['personal_information']->password_confirmation = '';
		$idx = 0;
		foreach ($params as $k => $v) {

			//$user[$v->docParamName][$paramName] = $v->value = '';

			$iteration = $v->iteration;
			$docParamId = $v->docParamId;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->paramType;
			$slug = $v->slug;
			$position = $v->position;
			$paramId = $v->paramId;
			$paramParent = $v->paramParent;
//			$paramParentPosition = '';


			$user[$docParamName]['docParamId'] = $docParamId;
			$user[$docParamName][$paramId]['paramName'] = $paramName;
			$user[$docParamName][$paramId]['paramId'] = $paramId;
			$user[$docParamName][$paramId]['paramParentId'] = $paramParent;
//			$user[$docParamName][$paramId]['paramParentPosition'] = $paramParentPosition;
			$user[$docParamName][$paramId]['slug'] = $slug;
			$user[$docParamName][$paramId]['paramValue'] = '';
			$user[$docParamName][$paramId]['inputType'] = $inputType;

		}

		return Response::json($user);
	}

	public function columnIndexEmployer()
	{
		$personal_information = new stdClass();
		$user = array();
//		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
//											   param.name AS paramName,
//											   doc_param.name AS docParamName ,
//											   param_type.name AS paramType
//											   FROM	param
//											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
//											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
//											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
//											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
//											   LEFT JOIN param_type ON param.type_id = param_type.id
//											   WHERE doc_type_id = 1
//											   AND doc_param.doc_sub_type = 'employer'
//											   AND authorized = 1"));
		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
											   param.slug AS slug,
											   param.id AS paramId,
											   param.name AS paramName,
											   param.position AS paramPosition,
											   param.param_parent_id AS paramParent,
											   doc_param.name AS docParamName,
											   param_type.name AS paramType,
											   doc_param.id AS docParamId
											   FROM	param
											   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
											   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
											   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
											   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
											   LEFT JOIN param_type ON param.type_id = param_type.id
											   WHERE doc_type_id = 1
											   AND doc_param.doc_sub_type = 'employer'
											   AND authorized = 1"));
		if (!Auth::user()) {
			$userpersonal_information = Schema::getColumnListing('type_user');
			$userpersonal_information = (object)$userpersonal_information;
			foreach ($userpersonal_information as $key => $value) {
				$personal_information->$value = '';
			}
		} else {
			$id = Auth::user()->id;
			$personal_information = User::find($id);
		}
		$user['personal_information'] = $personal_information;        // $user['personal_information']->password_confirmation = '';
		foreach ($params as $k => $v) {

			//$user[$v->docParamName][$paramName] = $v->value = '';

			$iteration = $v->iteration;
			$docParamId = $v->docParamId;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->paramType;
			$slug = $v->slug;
			$position = $v->position;
			$paramId = $v->paramId;
			$paramParent = $v->paramParent;
//			$paramParentPosition = '';


			$user[$docParamName]['docParamId'] = $docParamId;
			$user[$docParamName][$paramId]['paramName'] = $paramName;
			$user[$docParamName][$paramId]['paramId'] = $paramId;
			$user[$docParamName][$paramId]['paramParentId'] = $paramParent;
//			$user[$docParamName][$paramId]['paramParentPosition'] = $paramParentPosition;
			$user[$docParamName][$paramId]['slug'] = $slug;
			$user[$docParamName][$paramId]['paramValue'] = '';
			$user[$docParamName][$paramId]['inputType'] = $inputType;

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

		$user = JWTAuth::parseToken()->authenticate();
		$id = Auth::user()->id;
		if (isset($_POST['status'])) {
			$status = request()->get('status');
		} else {

			$status = request()->get('status');
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
//	public function store()
//	{
//		$all = Input::all();
//		if (isset($all['from']) && $all['from'] == 'tables') {
//			$funcFromAdmin = true;
//			$allpersonal_information = $all['user'];
//		} else {
//			$funcFromAdmin = false;
//			$allpersonal_information = $all['user']['personal_information'];
//		}
//		$id = $allpersonal_information['id'];
//		unset($all['personal_information']);
//		$param = User::find($id);
//		if ($param) {
//			$param->id = $id;
//		} else {
//			$param = new User();
//		}
//		$param->type = $allpersonal_information['type'];
//		$param->subtype = $allpersonal_information['subtype'];
//		$param->email = $allpersonal_information['email'];
//
//		$param->gender = $allpersonal_information['gender'];
//		$param->martial_status = $allpersonal_information['martial_status'];
//		$param->education_status = $allpersonal_information['education_status'];
//
//		//$param->password_new = Input::get('password_new');
//		$param->first_name = $allpersonal_information['first_name'];
//		$param->last_name = $allpersonal_information['last_name'];
//		$param->street_1 = $allpersonal_information['street_1'];
//
//		$param->city = $allpersonal_information['city'];
//		$param->state = $allpersonal_information['state'];
//		$param->zipcode = $allpersonal_information['zipcode'];
//		$param->country = $allpersonal_information['country'];
//		$param->phone_1 = $allpersonal_information['phone_1'];
//
//		$param->mobile = $allpersonal_information['mobile'];
//
//		$param->date_of_birth = new DateTime($allpersonal_information['date_of_birth']);
//		$param->date_of_birth->format('Y-m-d');
//		$param->last_login = new DateTime('now');
//
//		$param->registration = $allpersonal_information['registration'];
//		$param->send_newsletters = $allpersonal_information['send_newsletters'];
//		$param->save();
//		unset($all['user']['personal_information']);
//		if ($funcFromAdmin) {
//			return Response::json('function from admin');
//			die;
//		}
//		$update = null;
//		$authId = $param->id;
//		foreach($all['user'] as $doc_param => $param_object){
//
//			foreach ($param_object as $param_key => $param_value) {
//				$obj[$doc_param][$param_key] = $param_value;
//			}
//		}
//
//		foreach($obj as $docParamName => $docParamVals) {
//
//			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->pluck('id');
//			$iterableCount = 0;
//
//			foreach($docParamVals as $param => $props) {
////				/dd($docParamVals);
//				if(!array_key_exists ( 'docParamId' , $docParamVals )) {
////					print_r($param.' is an iterrable Param');
//					foreach($props as $propKey => $propVal) {
//
//						print_r($docParamVals);
//
//
//						if(isset($propVal['paramValue'])){
//
//						}else{
//							//print_r($propKey);
//						}
//						if($propVal['paramValue']){
//
//
//							$paramValue = $propVal['paramValue'];
//							if(is_array($paramValue)) {
//								$paramValue = implode('|',$paramValue);
//								//print_r($paramValue);
//							}
//
//						}else{
//							$paramValue='';
//						};
//						$paramName  = $propVal['paramName'];
//						$iterable = $param;
//
//
//						$param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->pluck('id');
//
//						if ($param_id) {
//							//checking where the values come from? from param_value? or from short/long?
//							$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
//
//							$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$authId)->pluck('id');
//							if(!$existsId) {
//								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$authId)->pluck('id');
//							}
//
//
//
//							if($existsId) {
//
//								if(!$value_ref) {
//									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
//								} else {
//									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
//								}
//							}else {
//								if(!$value_ref) {
//									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
//								} else {
//									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
//								}
//							}
//						}
//
//					}
//				}else if(array_key_exists ( 'docParamId' , $docParamVals )){
//					//print_r($docParamVals);
//					if(isset($docParamVals['docParamId'])){
//						unset($docParamVals['docParamId']);
//
//					}else {
//
//					}
//
//					if(isset($props['paramValue'])){
//						$paramValue = $props['paramValue'];
//
//					}else{
//						$paramValue= '';
//						print_r('docParamVVVVAlue');
//					}
//
//
//					if(is_array($paramValue)) {
//						$paramValue = implode('|',$paramValue);
//
//					}
//					$param_id = $param;
//					//$param_id = DB::table('param')->where('name',  'company_name')->where('doc_param_id', $doc_param_id)->pluck('id');
//
//					if($param_id == null) {
//						print_r('some thing wrong with param: '.$param);
//					}
//
//					$value_ref = DB::table('param_value')->where('value', $paramValue)->pluck('id');
//					$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$authId)->pluck('id');
//					if($existsId) {
//						if(!$value_ref) {
//							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
//						} else {
//							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
//						}
//					} else {
//						if(!$value_ref) {
//							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
//						} else {
//							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
//						}
//					}
//				}
//				$iterableCount ++;
//			}
//		}
//
//		//return Response::json($obj);
//	}

	public function store()
	{
		$all = request()->all();
		if (isset($all['from']) && $all['from'] == 'tables') {
			$funcFromAdmin = true;
			$allpersonal_information = $all['user'];
		} else {
			$funcFromAdmin = false;
			$allpersonal_information = $all['personal_information'];
		}
		$id = $allpersonal_information['id'];
		unset($all['personal_information']);
		$param = User::find($id);
		$userPI = $param;
		if ($param) {
			$param->id = $id;
		} else {
			$param = new User();
		}
		$param->type = $allpersonal_information['type'];
		$param->subtype = $allpersonal_information['subtype'];
		$param->email = $allpersonal_information['email'];

		$param->gender = $allpersonal_information['gender'];
		$param->martial_status = $allpersonal_information['martial_status'];
		$param->education_status = $allpersonal_information['education_status'];

		//$param->password_new = Input::get('password_new');
		$param->first_name = $allpersonal_information['first_name'];
		$param->last_name = $allpersonal_information['last_name'];
		$param->street_1 = $allpersonal_information['street_1'];

		$param->city = $allpersonal_information['city'];
		$param->state = $allpersonal_information['state'];
		$param->zipcode = $allpersonal_information['zipcode'];
		$param->country = $allpersonal_information['country'];
		$param->phone_1 = $allpersonal_information['phone_1'];

		$param->mobile = $allpersonal_information['mobile'];

//		$param->date_of_birth = new DateTime($allpersonal_information['date_of_birth']);
//		$param->date_of_birth->format('Y-m-d');
		$param->last_login = new DateTime('now');

		$param->registration = $allpersonal_information['registration'];
		$param->send_newsletters = $allpersonal_information['send_newsletters'];
		$param->save();
		unset($all['user']['personal_information']);
		if ($funcFromAdmin) {
			return Response::json('function from admin');
			die;
		}
		$update = null;
		$authId = $param->id;
		foreach($all as $doc_param => $param_object){

			foreach ($param_object as $param_key => $param_value) {
				$obj[$doc_param][$param_key] = $param_value;
			}
		}

		foreach($obj as $docParamName => $docParamVals) {
			$doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 1)->pluck('id');
			$iterableCount = 0;
			foreach($docParamVals as $param => $props) {
				//dd(array_key_exists ( 'docParamId' , $docParamVals ));
				//dd($docParamVals);
				if(!array_key_exists ( 'docParamId' , $docParamVals )) {
					//print_r('array');
					foreach($props as $propKey => $propVal) {
						if(isset($propVal['paramValue'])){

						}else{
							//print_r($propKey);
						}
						if($propVal['paramValue']){


							$paramValue = $propVal['paramValue'];
							if(is_array($paramValue)) {
								$paramValue = implode('|',$paramValue);
								//print_r($paramValue);
							}

						}else{
							$paramValue='';
						};
						$paramName  = $propVal['paramName'];
						$iterable = $param;

						$param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->value('id');

						if ($param_id) {
							//checking where the values come from? from param_value? or from short/long?
							$value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');

							$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$authId)->value('id');
							if(!$existsId) {
								$existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$authId)->value('id');
							}



							if($existsId) {

								if(!$value_ref) {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
								} else {
									DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								}
							}else {
								if(!$value_ref) {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
								} else {
									DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>$iterableCount,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
								}
							}
						}

					}
				}else if(array_key_exists ( 'docParamId' , $docParamVals )){

					//print_r('single');
					if(isset($props['paramValue'])){
						$paramValue = $props['paramValue'];
					}else{
						//print_r('here');
						$paramValue= '';
					}


					if(is_array($paramValue)) {
						$paramValue = implode('|',$paramValue);

					}
					$param_id = $param;
					//$param_id = DB::table('param')->where('id',  $param)->where('doc_param_id', $doc_param_id)->value('id');
					if($param_id == null) {
						dd('some thing wrong with param: '.$param);
					}

					$value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');
					$existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$authId)->pluck('id');
					if($existsId) {
						if(!$value_ref) {
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
						} else {
							DB::table('sys_param_values')->where('id',$existsId)->update(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
						}
					} else {
						if(!$value_ref) {
							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>NULL,'value_short'=>$paramValue,'value_long'=>NULL]);
						} else {
							DB::table('sys_param_values')->insert(['doc_type'=>1,'ref_id'=>$authId,'param_id'=>$param_id,'iteration'=>null,'value_ref'=>$value_ref,'value_short'=>NULL,'value_long'=>NULL]);
						}
					}
				}
				$iterableCount ++;
			}
		}
		$obj = array('personal_information' => $userPI) + $obj;
		//$obj['personal_information'] = $userPI;

		return response()->json($obj);
	}




	public function calc_match($postId = 3, $userId = 9)
	{


		$postUserId;

		$post = array();
		$postInfo = Post::find($postId);
		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_post.*,
										   param.name AS paramName,
										   param.slug AS slug,
										   param_type.name AS paramType,
										   param_value.value AS paramValue,
										   doc_param.name AS docParamName,
										   doc_param.id AS docParamId
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_post ON sys_param_values.ref_id = type_post.id
										   LEFT JOIN param_type ON param.type_id = param_type.id
										   WHERE  type_post.id = " . $postId));

		$isMultiple = false;
		$post['postInfo'] = $postInfo;
		foreach ($params as $k => $v) {

			$iteration = $v->iteration;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->paramType;
			$paramValue = $v->paramValue;
			$docParamId = $v->docParamId;
			$slug = $v->slug;
			$logo_param_id = DB::table('param')->where('name', 'company_logo')->pluck('id');
			$ref_id = DB::table('type_post')->where('id', $postId)->pluck('user_id');
			$postUserId = $ref_id;
			$company_logo = DB::table('sys_param_values')->where('param_id', $logo_param_id)->where('ref_id', $ref_id)->value('value_short');
			$post['postInfo']['company_logo'] = $company_logo;


			if ($v->value_ref == null) {
				$value = $v->value_short;
			} else {
				$value = $v->value;
			}


			if ($iteration !== NULL) {
				$post[$docParamName][$iteration]['docParamId'] = $docParamId;
				$post[$docParamName][$iteration][$paramName]['paramName'] = $paramName;
				$post[$docParamName][$iteration][$paramName]['slug'] = $slug;
				$post[$docParamName][$iteration][$paramName]['paramValue'] = $value;
				$post[$docParamName][$iteration][$paramName]['inputType'] = $inputType;

				//$post[$docParamName][$iteration][$paramName] = $value;


			} elseif ($iteration == NULL) {
				$post[$docParamName]['docParamId'] = $docParamId;
				$post[$docParamName][$paramName]['paramName'] = $paramName;
				$post[$docParamName][$paramName]['slug'] = $slug;
				$post[$docParamName][$paramName]['paramValue'] = $value;
				$post[$docParamName][$paramName]['inputType'] = $inputType;


				//$post[$docParamName][$paramName] = $value;

			}

		}


		$user = array();
		$userpersonal_information = User::find($userId);
		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
										   param.name AS paramName,
										   param.slug AS slug,
										   param_type.name AS inputType,
										   doc_param.name AS docParamName,
										   doc_param.id AS docParamId
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id
										   LEFT JOIN param_type ON param.type_id = param_type.id
										   WHERE doc_type_id = 1
										   AND type_user.id = " . $userId));


		$user['personal_information'] = $userpersonal_information['original'];

		foreach ($params as $k => $v) {
			$iteration = $v->iteration;
			$docParamId = $v->docParamId;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->inputType;
			$slug = $v->slug;

			if ($v->value_ref == null) {
				$value = $v->value_short;
			} else {
				$value = $v->value;
			}

			if ($iteration !== NULL) {


				$values = array();
				if ($inputType == 'checklist') {
					$value = explode('|', $value);
					foreach ($value as $key => $value) {
						//			$paramOptions[$key] = [];
//
//						$option['value'] = $value;
//						$option['text'] = $value;
//						$values[]  =$option;
						if ($value) {
							$values[] = $value;
						}
					}
				}
				if ($values) {
					$value = $values;
				}

				$user[$docParamName][$iteration]['docParamId'] = $docParamId;
				$user[$docParamName][$iteration][$paramName]['paramName'] = $paramName;
				$user[$docParamName][$iteration][$paramName]['slug'] = $slug;
				$user[$docParamName][$iteration][$paramName]['paramValue'] = $value;
				$user[$docParamName][$iteration][$paramName]['inputType'] = $inputType;

			} elseif ($iteration == NULL) {

				$values = array();
				if ($inputType == 'checklist') {
					$value = explode('|', $value);
					foreach ($value as $key => $value) {

						if ($value) {
							$values[] = $value;
						}
					}
				}
				if ($values) {
					$value = $values;
				}
				$user[$docParamName]['docParamId'] = $docParamId;
				$user[$docParamName][$paramName]['paramName'] = $paramName;
				$user[$docParamName][$paramName]['slug'] = $slug;
				$user[$docParamName][$paramName]['paramValue'] = $value;
				$user[$docParamName][$paramName]['inputType'] = $inputType;

			}
		}

////////////////////////////////all of the above code is just waisted. need to call User::show(id) and Post::show(id)
		$post['postInfo'] =$post['postInfo']['original'];
		unset($user['personal_information']);
		$match['total'] = 0;


		$score = 0;


		function calc($user, $post) {
			$match['dev'] = [];
			$match['total']=0;
			$points = 10;

			foreach($user as $userDocParamName => $userDocParamValues)
			{
				if (array_key_exists($userDocParamName, $post))
				{
						unset($userDocParamValues['docParamId']);
						unset($post[$userDocParamName]['docParamId']);
						foreach($userDocParamValues as $userParamName => $userParamValue)
						{
							if(!is_int($userParamName))
							{
								if (array_key_exists($userParamName, $post[$userDocParamName]))
								{
									//regular non-iterable
									if($userParamValue['paramValue'] == $post[$userDocParamName][$userParamName]['paramValue'])
									{
										$match['dev'][] = $userParamValue['paramValue'];
										$match['total'] = $match['total']+$points;
										echo 'this one is a match: '. $userParamName . PHP_EOL;
									}
								}
								else
								{
									echo 'doesnt exist in post: '. $userParamName . 'from docParam: '. $userDocParamName . PHP_EOL;
								}
							}
							else if(is_int($userParamName))
							{
								unset($userParamValue['docParamId']);
								foreach($userParamValue as $paramName => $paramValue)
								{
									if (array_key_exists($paramName, $post[$userDocParamName]))
									{
										//regular non-iterable

										if($paramValue['paramValue'] == $post[$userDocParamName][$paramName]['paramValue'])
										{
											$match['dev'][] = $paramValue['paramValue'];
											$match['total'] = $match['total']+$points;
											echo 'this one is a match: '. $paramName . PHP_EOL;
										}else
										{
											echo 'this one is not a match: '. $paramName . PHP_EOL;
										}
									}
									else
									{
										echo 'doesnt exist in post: '. $paramName . PHP_EOL;

									}
								}
							}

						}
				}
				else
				{

				}
				echo PHP_EOL;

			}

		return $match['total'];

		}

		$result = calc($user,$post);

		return Response::json(array('result'=>$result, 'user'=>$user, 'post' => $post));


	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{

		$user = array();
		$userpersonal_information = User::find($id);
		$params = DB::select(DB::raw("SELECT param.*, sys_param_values.*,param_value.*,type_user.*,
										   param.slug AS slug,
											   param.id AS paramId,
											   param.name AS paramName,
											   param.position AS paramPosition,
											   param.param_parent_id AS paramParent,
											   doc_param.name AS docParamName,
											   param_type.name AS paramType,
											   doc_param.id AS docParamId
										   FROM	param
										   LEFT JOIN doc_param ON param.doc_param_id = doc_param.id
										   LEFT JOIN sys_param_values ON param.id = sys_param_values.param_id
										   LEFT JOIN param_value ON sys_param_values.value_ref = param_value.id
										   LEFT JOIN type_user ON sys_param_values.ref_id = type_user.id 
										   LEFT JOIN param_type ON param.type_id = param_type.id
										   WHERE doc_type_id = 1 
										   AND type_user.id = " . $id));

		//return($params);
		$user['personal_information'] = $userpersonal_information['original'];

		foreach ($params as $k => $v) {
			$iteration = $v->iteration;
			$docParamId = $v->docParamId;
			$docParamName = $v->docParamName;
			$paramName = $v->paramName;
			$inputType = $v->paramType;
			$slug = $v->slug;
			$position = $v->position;
			$paramId = $v->paramId;
			$paramParent = $v->paramParent;

			if ($v->value_ref == null) {
				$value = $v->value_short;
			} else {
				$value = $v->value;
			}

			if ($iteration !== NULL) {


				$values = array();
				if ($inputType == 'checklist') {
					$value = explode('|', $value);
					foreach ($value as $key => $value) {
						//			$paramOptions[$key] = [];
//
//						$option['value'] = $value;
//						$option['text'] = $value;
//						$values[]  =$option;
						if ($value) {
							$values[] = $value;
						}
					}
				}
				if ($values) {
					$value = $values;
				}


				$user[$docParamName][$iteration]['docParamId'] = $docParamId;
				$user[$docParamName][$iteration][$paramId]['paramName'] = $paramName;
				$user[$docParamName][$iteration][$paramId]['paramId'] = $paramId;
				$user[$docParamName][$iteration][$paramId]['paramParentId'] = $paramParent;
				$user[$docParamName][$iteration][$paramId]['slug'] = $slug;
				$user[$docParamName][$iteration][$paramId]['paramValue'] = $value;
				$user[$docParamName][$iteration][$paramId]['inputType'] = $inputType;
			} elseif ($iteration == NULL) {

				$values = array();
				if ($inputType == 'checklist') {
					$value = explode('|', $value);
					foreach ($value as $key => $value) {

						if ($value) {
							$values[] = $value;
						}
					}
				}
				if ($values) {
					$value = $values;
				}
				$user[$docParamName]['docParamId'] = $docParamId;
				$user[$docParamName][$paramId]['paramName'] = $paramName;
				$user[$docParamName][$paramId]['paramId'] = $paramId;
				$user[$docParamName][$paramId]['paramParentId'] = $paramParent;
				$user[$docParamName][$paramId]['slug'] = $slug;
				$user[$docParamName][$paramId]['paramValue'] = $value;
				$user[$docParamName][$paramId]['inputType'] = $inputType;

			}
		}

		return Response::json($user);
	}


//	public function getProfilePic()
//	{
//		$param_id =  DB::table('param')->where('name', 'profile_pic')->pluck('id');
//		$profilePic =  DB::table('sys_param_values')->where('ref_id',$id)
//													->where('param_id',$param_id)->first();
//		return Response::json($profilePic);
//	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

//	/**
//	 * Update the specified resource in storage.
//	 *
//	 * @param  int $id
//	 * @return Response
//	 */
//	public function update($id)
//	{
//		//
//	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		User::destroy($id);
		return Response::json($id);
	}


	public function arrayRecursiveDiff($aArray1, $aArray2)
	{// clones two arrays with each other;
		$aReturn = array();

		foreach ($aArray1 as $mKey => $mValue) {
			if (array_key_exists($mKey, $aArray2)) {
				if (is_array($mValue)) {
					$aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
					if (count($aRecursiveDiff)) {
						$aReturn[$mKey] = $aRecursiveDiff;
					}
				} else {
					if ($mValue != $aArray2[$mKey]) {
						$aReturn[$mKey] = $mValue;
					}
				}
			} else {
				$aReturn[$mKey] = $mValue;
			}
		}
		return $aReturn;
	}
}
