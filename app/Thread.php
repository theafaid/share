<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadReceivedNewComment;

class Thread extends Model
{
    use Likable;
    use Subscribed;
    use RecordActivity;

    protected $guarded = [];
    protected $dates = ['created_at'];
    protected $with = ['channel', 'user'];
    protected $withCount = ['comments', 'likes', 'subscriptions'];
    protected $appends = ['imagePath', 'isSubscribed'];

    protected static function boot(){
        parent::boot();

        static::created(function($thread){
            $thread->subscribe($thread->user_id);
        });

        static::deleting(function($model){
            $model->comments->each->delete();
        });
    }

    /**
     * @return string
     */
    public function getRouteKeyName(){
        return "slug";
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
    public function getImagePathAttribute(){
        return $this->image ? "/storage/{$this->image}" : "/design/img/default/thread.png";
    }


    public function channel(){
        return $this->belongsTo('App\Channel');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
     * @param $comment
     * @return Model
     */
    public function addComment($body){
        $comment = $this->comments()->create([
            'body' => $body,
            'user_id' => auth()->id()
        ]);

        $this->notifySubscribers($comment);

        return $comment;
    }

    protected function notifySubscribers($comment){
        foreach($this->subscriptions as $subscription){
            if($subscription->user->id != $comment->user_id){
                $subscription->user->notify(new ThreadReceivedNewComment($comment));
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function likes(){
        return $this->morphMany('App\Like', 'likable');
    }
}
