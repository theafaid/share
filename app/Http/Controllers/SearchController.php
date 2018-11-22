<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(){
        if($search = request('q')){

            $result = Thread::search($search)->paginate(20);

            if(request()->expectsJson()){
                return $result;
            }else{
                return view("threads.index",
                    [
                        'title'   => "Result for '{$search}'",
                        'threads' => $result,
                        'trending' => (new Thread())->getTrending()
                    ]
                );
            }
        }
    }
}
