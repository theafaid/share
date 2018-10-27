<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Queries\ThreadsFilter;
class ThreadsController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->getThreads();

        if(request()->wantsJson()){
            return $data;
        }

        return view('threads.index', [
            'title'   => $data['title'],
            'threads' => $data['data']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store()
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
            'image' => 'image|mimes:jpg,jpeg,png',
            'channel_id' => 'required|numeric|exists:channels,id'
        ]);

        $data['image'] = request()->hasFile('image') ? request()->file('image')->store('threads') : null ;
        $data['user_id' ] = auth()->id();
        $data['slug'] = str_slug($data['title']);

        $thread = Thread::create($data);

        return redirect(route('threads.show', $thread->slug));
    }


    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        //
    }


    /**
     *
     */
    public function update()
    {
        //
    }


    /**
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Thread $thread)
    {
        $this->authorize("update", $thread);

        $thread->delete();

        if(request()->wantsJson()){
            return response([], 204);
        }

        return redirect()->route('threads.index');
    }


    protected function getThreads($count = null){

        if(request()->has('by')){
            return ThreadsFilter::bySpecificUser(request('by'), $count);
        }

        if(request()->has('filter')){

            if(request('filter') === 'popular'){
                return ThreadsFilter::popularThreads($count);
            }

        }

        return ThreadsFilter::latestThreads($count);
    }
}
