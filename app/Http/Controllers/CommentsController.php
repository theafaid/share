<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Comment;
class CommentsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store(Thread $thread)
    {
        request()->validate([
            'body' => 'required|string|max:1000'
        ]);

        $thread->addComment([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }


    public function update(Comment $comment)
    {
        $this->authorize('update', $comment);

        $data = request()->validate(['body' => 'required|string|max:1000']);
        $comment->body = $data['body'];
        $comment->save();

        if(request()->expectsJson()){
            return response([], 204);
        }

        return back();
    }


    /**
     * @param Comment $comment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('update', $comment);

        $comment->delete();

        if(request()->expectsJson()){
            return response([], 204);
        }

        return back();
    }
}
