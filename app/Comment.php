<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use Likable;
    use RecordActivity;

    protected $guarded = [];
    protected $with = ['user', 'likes'];
    protected $withCount = ['likes'];
    protected $appends = ['isLiked'];

    protected static function boot(){
        parent::boot();
        // increase comments count on the thread
        static::created(function($comment){
            $comment->thread->increment("comments_count");
        });
        // decrease comments count on the thread
        static::deleted(function($comment){
            $comment->thread->decrement("comments_count");
        });
    }

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }

    /**
     * @return string
     */
    public function path(){
        return route("threads.show", $this->thread->slug) . "#comment-{$this->id}";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread(){
        return $this->belongsTo('App\Thread');
    }

}
