<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reply;

class PostController extends Controller
{
    const PAGINATION_COUNT = 5;

    public function addPost(Request $request){
        $text = $request->get("text");
        if($text){
            return Post::create([
                "user_id" => $request->user()->id,
                "text" => $text
            ]);
        }
        return $this->validateErrorResponse();

    }

    public function addReply(Post $post,Request $request){
        $text = $request->get("text");
        if($text) {
            return Reply::create([
                "user_id" => $request->user()->id,
                "post_id" => $post->id,
                "text" => $text
            ]);
        }
        return $this->validateErrorResponse();

    }

    public function getPosts(Request $request){
        $page = $request->get("page");
        $count = Post::all()->count();
        $max_page = ceil($count / self::PAGINATION_COUNT);
        if($page < 1){
            $page = 1;
        }elseif($max_page < $page){
            $page = $max_page;
        }
        $data = Post::skip(($page-1)*self::PAGINATION_COUNT)->take(self::PAGINATION_COUNT)->with("reply");
        $urls = $this->calculateLinks($page, $count);
        return [
            "data" => $data->get(),
            "total" => $count,
            "prev" => $urls[0],
            "next" =>$urls[1],
        ];
    }

    protected function calculateLinks($page, $count){
        $url = route("posts") . "?page=";
        $prev = $next = "";
        if($page * self::PAGINATION_COUNT < $count){
            $next = $url . ($page + 1);
        }
        if($page != 1){
            $prev = $url . ($page + -1);
        }
        return [$prev,$next];

    }

    protected function validateErrorResponse(){
        return response()->json(["error" => "field text required"],400);
    }
}
