<?php

namespace App\Http\Controllers;

use App\Comment;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Comment $comment){
        if(! $comment->likes()->where('user_id', auth()->id())->exists()){
        	$comment->like();
        }

        if(request()->expectsJson()){
            return response([], 204);
        }

        return back();
    }

    public function destroy(Comment $comment){
        if($comment->likes()->where(['user_id' => auth()->id()])->exists()){
            $comment->unlike();
        }

        if(request()->expectsJson()){
            return response([], 204);
        }

        return back();
    }
}
