<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Response;
use DB;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\PostRepository;

class PostController extends Controller
{

    /**
     * The post repository instance.
     *
     * @var PostRepository
     */

    protected $posts;

    /**
     * Create a new controller instance.
     *
     * @param  PostRepository  $posts
     * @return void
     */

    public function __construct(PostRepository $posts)
    {
        $this->middleware('jwt.auth');

        $this->posts = $posts;
    }




    public function index(Request $request)
    {
        //$posts = Post::where('user_id', $request->user()->id)->get();

        //return response()->json([ 'posts' => $this->posts->forUser( $request->user() ) ]);
          return response()->json([ 'posts' => Post::all() ]);
    }

    public function savePost()
    {




        $all = request()->all();
        $allPostInfo = $all['post']['postInfo'];
        unset($all['post']['files']);
        unset($all['post']['personal_information']);
        unset($all['post']['company']);
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
        //	$post->description_short =$allPostInfo['description_short'];
        $post->description = $all['post']['postInfo']['description'];
        $post->authorized = 1;
        $post->save();


        unset($all['post']['postInfo']);
        foreach($all['post'] as $doc_param => $param_object){
            unset($param_object['docParamId']);
            foreach ($param_object as $param_key => $param_value) {
                $obj[$doc_param][$param_key] = $param_value;
            }
        }
        //dd($obj);
        foreach($obj as $docParamName => $docParamVals) {
            $doc_param_id = DB::table('doc_param')->where('name', $docParamName)->where('doc_type_id', 2)->value('id');
            $iterableCount = 0;
            foreach($docParamVals as $param => $props) {

                if(is_int($param)) {
                    if($param['docParamId']) {
                        unset($param['docParamId']);
                    }
                    foreach($props as $propKey => $propVal) {
                        $paramValue = $propVal['paramValue'];
                        if(is_array($paramValue)) {
                            $paramValue = implode('|',$paramValue);
                        }
                        $paramName  = $propVal['paramName'];

                        $iterable = $param;

                        $param_id = DB::table('param')->where('name', $paramName)->where('doc_param_id', $doc_param_id)->value('id');
                        if ($param_id) {
                            //checking where the values come from? from param_value? or from short/long?
                            $value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');

                            // if($iterable){
                            $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',null)->where('ref_id',$post->id)->value('id');
                            if(!$existsId) {
                                $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',$iterableCount)->where('ref_id',$post->id)->value('id');
                            }
                            // }else{
                            // $existsId  = DB::table('sys_param_values')->where('param_id',$param_id)->where('iteration',NULL)->where('ref_id',$post->id)->value('id');
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
                        }else if(!$param_id){
                            dd($paramName);
                        }
                    }
                }else if(!is_int($param)){

                    $paramValue = $props['paramValue'];
                    if(is_array($paramValue)) {
                        $paramValue = implode('|',$paramValue);
                    }
                    $param_id = DB::table('param')->where('name', $param)->where('doc_param_id', $doc_param_id)->value('id');
                    if(!$param_id){
                        dd($param);
                    }

                    $value_ref = DB::table('param_value')->where('value', $paramValue)->value('id');
                    $existsId = DB::table('sys_param_values')->where('param_id',$param_id)->where('ref_id',$post->id)->value('id');
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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->posts()->create([
            'name' => $request->name,
        ]);
    }

}
