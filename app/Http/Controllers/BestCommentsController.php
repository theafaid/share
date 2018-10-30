<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Gate;

class BestCommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function store(Comment $comment){
        if(Gate::denies('update', $comment->thread)){
            return response("the action is unautorized", 403);
        }
        $comment->markAsBest();
        return response([], 204);
    }

    public function remove(Comment $comment){
        $this->authorize('update', $comment->thread);
        $comment->removeBest();
        return response([], 204);
    }
}
