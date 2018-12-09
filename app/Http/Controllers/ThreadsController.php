<?php

namespace App\Http\Controllers;

use App\Rules\FreeSpam;
use App\Rules\Recaptcha;
use App\Thread;
use App\Queries\ThreadsFilter;

class ThreadsController extends Controller
{

    public function __construct()
    {
         $this->middleware('auth', ['except' => ['index', 'show']]);
         $this->middleware('verified',  ['only' => ['create', 'store']]);
    }

    /**
     * Display a listing of the resource.
     * Get Threads by [latest, popular, unanswered]
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
            'threads' => $data['data'],
            'trending' => (new Thread())->getTrending()
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
     */
    public function store()
    {
        $data = request()->validate([
            'title' => ['required', 'string', 'max:255', new FreeSpam()],
            'body'  => ['required', 'string', 'min:255', new FreeSpam()],
            'image' => 'image|mimes:jpg,jpeg,png',
            'channel_id' => 'required|numeric|exists:channels,id',
            'g-recaptcha-response' => [new Recaptcha()]
        ]);

        unset($data['g-recaptcha-response']);

        // Upload a thread image
        $data['image'] = request()->hasFile('image') ?
            request()->file('image')->store('threads') : null ;

        $data['user_id' ] = auth()->id();

        $thread = Thread::create($data);

        return redirect(route('threads.show', $thread->slug));

    }

    /**
     * @param Thread $thread
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function show(Thread $thread)
    {
        $thread->read();

        $thread->arrangeTrending();

        $thread->recordVisit();

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
    public function update(Thread $thread)
    {
        if(! auth()->user()->can('update', $thread)){
            return response(['message' => 'unauthorized'], 403);
        }

        $data = request()->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|min:255',
//            'image'  => 'sometimes|nullable|image|mimes:jpeg,jpg,png',
//            'channel_id' => 'required|numeric|exists:channels,id'
        ]);

        $thread->update($data);

        return $thread;
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

        // Get threads by spesific user
        if(request()->has('by')){
            return ThreadsFilter::bySpecificUser(request('by'), $count);
        }

        if(request()->has('filter')){

            // Filter threads by popularity
            if(request('filter') === 'popular'){
                return ThreadsFilter::popularThreads($count);
            }

            // Filter threads by unanswered
            if(request('filter') == 'unanswered'){
                return ThreadsFilter::unansweredThreads($count);
            }

        }

        // Get latest threads
        return ThreadsFilter::latestThreads($count);
    }
}
