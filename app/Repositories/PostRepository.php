<?php

namespace App\Repositories;

use App\User;
use App\Post;
use DB;

use Schema;
use response;


class PostRepository
{

    public function getAllPosts()
    {
		return Post::all();
//			->orderBy('created_at', 'desc')
//			->get();
    }

    public function forUser(User $user)
    {
        return Post::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function postsWithMatch(User $user){

        $posts = [];
        foreach(Post::all() as $post) {
            $match = $this->calcMatchPercentage($post, $user);
            $post['match'] = $match;
            $posts[] = $post;
        }
        //sorted on client side
        return $posts;
    }

    public function calcMatchPercentage(Post $post, User $user){
        $match = rand(0,5);
        return $match;
    }






}