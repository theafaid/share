<?php

namespace App;

trait Likable
{
    /**
     * @return mixed
     */
    public function likes(){
        return $this->morphMany('App\Like', 'likable');
    }

    /**
     * Create Like on Thread or Comment
     */
    public function like(){
        $this->likes()->create(['user_id' => auth()->id()]);
    }


    /**
     * Remove Like from Thread or Comment
     */
    public function unlike(){
        $this->likes()->where('user_id', auth()->id())->get()->each->delete();
    }

    /**
     * Check if User has liked the thread or comment before
     * @return bool
     */
    public function isLiked(){
        return !! $this->likes->where('user_id', auth()->id())->count();
    }
}