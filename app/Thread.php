<?php

namespace App;

use App\Events\NewCommentAdded;
use Illuminate\Database\Eloquent\Model;

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
     * @param $body
     * @param null $userId
     * @return Model
     */
    public function addComment($body, $userId = null){
        $comment = $this->comments()->create([
            'body' => $body,
            'user_id' => $userId ?: auth()->id()
        ]);

        event(new NewCommentAdded($comment));

        return $comment;
    }

    public function hasUpdatesFor(){
        if(! auth()->user()) return;
        $lastSeenTime = cache(sprintf("users.%.visits.%", auth()->id(), $this->id));

        return $this->updated_at->gt($lastSeenTime);
    }
}
