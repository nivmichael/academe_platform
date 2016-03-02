<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Response;
use DB;
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
