<?php

namespace App\Http\Controllers;

use App\Comment;

class BestCommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function store(Comment $comment){
        $this->authorize('update', $comment->thread);
        $comment->markAsBest();
        return response([], 204);
    }

    public function remove(Comment $comment){
        $this->authorize('update', $comment->thread);
        $comment->removeBest();
        return response([], 204);
    }
}
