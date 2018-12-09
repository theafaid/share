<?php

namespace App\Http\Controllers;


use App\Thread;

class LockThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changeLockMode(Thread $thread){
        if (! auth()->user()->can('update', $thread)) {
            return response(['message' => 'unauthorized'], 403);
        }

        $thread->locked ? $thread->unlock() : $thread->lock();
        return response([], 204);
    }
}
