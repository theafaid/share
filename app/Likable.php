<?php

namespace App;

use App\Notifications\UserHasLikedYourComment;

trait Likable
{
    protected static function bootLikable(){
        // when the model is delete
        // all likes in this model must be deleted also
        static::deleting(function($model){
            $model->likes->each->delete();
        });
    }
    /**
     * @return mixed
     */
    public function likes(){
        return $this->morphMany('App\Like', 'likable');
    }

    /**
     * Create Like on Thread or Comment
     */
    public function like($userId = null){
        $userId = $userId ?: auth()->id();
        $like = $this->likes()->create(['user_id' => $userId]);
        $this->notifyCommentOwner($like);
    }

    protected function notifyCommentOwner($like){
        if($like->user_id == $this->user_id) return ;
        $this->user->notify(new UserHasLikedYourComment($like));
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
    public function getIsLikedAttribute(){
        return !! $this->likes->where('user_id', auth()->id())->count();
    }
}