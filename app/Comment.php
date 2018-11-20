<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use Likable;
    use RecordActivity;

    protected $guarded = [];
    protected $with = ['user', 'likes'];
    protected $withCount = ['likes'];
    protected $appends = ['isLiked', 'isBest'];

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
     * Get the path of the comment
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

    /**
     * @return mixed
     */
    public function wasJustPublished(){
        return $this->created_at->gt(Carbon::now()->subSecond(1));
    }

    public function mentionedUsers(){
        preg_match_all('/\@([\w]+)/', $this->body, $matches);
        return $matches[1];
    }
    /**
     * If the body of the comment has a mentioned users
     * it well replace all mentioned users to be a link
     * that refer to them profile
     * @param $value
     */
    public function setBodyAttribute($value){
        $this->attributes['body'] =
            preg_replace('/\@([\w]+)/', '<a href="/profile/$1">$0</a>', $value);

    }

    /**
     * Mark a comment as best comment
     */
    public function markAsBest(){
        $this->thread->update(['best_comment_id' => $this->id]);
    }

    /**
     * Remove a comment form best comment
     */
    public function removeBest(){
        $this->thread->update(['best_comment_id' => null]);;
    }

    /**
     * Check if the comment is best comment in the thread or not
     */
    public function getIsBestAttribute(){
        return !! $this->thread->fresh()->best_comment_id == $this->id ;
    }
}
