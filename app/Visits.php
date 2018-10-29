<?php
namespace App;


use Illuminate\Support\Facades\Redis;

class Visits
{
    protected  $thread;

    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Record a visit for a thread
     * @return $this
     */
    public function record(){
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
     * Get visits count for the thread
     */
    public function count(){
        return Redis::get($this->cacheKey()) ?: 0;
    }

    public function cacheKey(){
        return "threads.{$this->thread->id}.visits";
    }
}