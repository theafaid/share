<?php

namespace App\Queries;
use App\Thread;
use App\User;

class ThreadsFilter
{
    /**
     * Get latest threads
     * @param int $count
     * @return mixed
     */
    public static function latestThreads($count = 20)
    {
        $data['title'] = "Latest Threads";
        $data['data'] = Thread::latest()->paginate($count);

        return $data;
    }

    /**
     * Get threads by specific user
     * @param $username
     * @param int $count
     * @return mixed
     */
    public static function bySpecificUser($username, $count = 20)
    {
        $user = User::whereUsername($username)->firstOrFail();
        $data['title'] = "{$user->username} Threads";
        $data['data'] = $user->threads()->latest()->paginate($count);

        return $data;
    }

    /**
     * Get popular threads
     * @param int $count
     * @return mixed
     */
    public static function popularThreads($count = 20)
    {
        $data['title'] = "Popular Threads";
        $data['data'] = Thread::withCount('comments')->orderBy('comments_count', 'desc')->paginate($count);

        return $data;
    }

    /**
     * Get unanswered threads
     * @param int $count
     * @return mixed
     */
    public static function unansweredThreads($count = 20){
        $data['title'] = "Unanswered Threads"; 
        $data['data']  = Thread::where('comments_count',"=", 0)->paginate($count);

        return $data;
    }
}