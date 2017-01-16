<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reply;
use App\Http\Requests\NewPostRequest;

class PostController extends Controller
{
    const PAGINATION_COUNT = 5;

    public function addPost(NewPostRequest $request){
        return Post::create([
            "user_id" => $request->user()->id,
            "text" => $request->get("text")
        ]);
    }

    public function addReply(Post $post,NewPostRequest $request){
        return Reply::create([
                "user_id" => $request->user()->id,
                "post_id" => $post->id,
                "text" => $request->get("text")
        ]);
    }

    public function getPosts(Request $request){
        return Post::with("reply")->paginate(self::PAGINATION_COUNT);
    }
}
