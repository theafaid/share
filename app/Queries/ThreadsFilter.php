<?php

namespace App\Queries;
use App\Thread;
use App\User;

class ThreadsFilter
{
    public static function latestThreads($count = 20)
    {
        $data['title'] = "Latest Threads";
        $data['data'] = Thread::latest()->paginate($count);

        return $data;
    }

    public static function bySpecificUser($username, $count = 20)
    {
        $user = User::whereUsername($username)->firstOrFail();
        $data['title'] = "{$user->username} Threads";
        $data['data'] = $user->threads()->latest()->paginate($count);

        return $data;
    }

    public static function popularThreads($count = 20)
    {
        $data['title'] = "Popular Threads";
        $data['data'] = Thread::withCount('comments')->orderBy('comments_count', 'desc')->paginate($count);

        return $data;
    }

    public static function unansweredThreads($count = 20){
        $data['title'] = "Unanswered Threads";
        $data['data']  = Thread::where('comments_count',"=", 0)->paginate($count);

        return $data;
    }
}