<?php

namespace App;

use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Likable;
    use Subscribed;
    use RecordActivity;
    use Commentable;

    protected $guarded = [];
    protected $dates = ['created_at'];
    protected $with = ['channel', 'user'];
    protected $withCount = ['comments', 'likes', 'subscriptions'];
    protected $appends = ['imagePath', 'isSubscribed'];

    protected static function boot(){
        parent::boot();
        // make the creator of the thread as subscriber
        static::created(function($thread){
            $thread->subscribe($thread->user_id);
        });
        // delete all commented which assosiated with the deleted thread
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
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)
            ->diffForHumans();
    }

    /**
     * @return string
     */
    public function getImagePathAttribute(){
        return $this->image ? "/storage/{$this->image}" : "/design/img/default/thread.png";
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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
     * Check if the thread has any update for the visitor scince
     * his last visit
     * @throws \Exception
     */
    public function hasUpdatesFor(){
        if(! auth()->user()) return;

        $lastSeenTime = cache(sprintf("users.%.visits.%", auth()->id(), $this->id));

        return $this->updated_at->gt($lastSeenTime);
    }

    public function saveVisitInCache(){
        if(auth()->user()){
            // Cache must have that user visited thread when he show a thread
            $cacheKey = sprintf("users.%.visits.%", auth()->id(), $this->id);
            cache()->forever($cacheKey, Carbon::now());
        }
    }

    /**
     * This function for arrange trending threads by visits
     * it increment the key by one every single visit
     */
    public function arrangeTrending(){
        Redis::zincrby('trending_threads', 1, json_encode([
            'title' => $this->title,
            'link'  => "/threads/{$this->slug}"
        ]));
    }

    /**
     * @return array
     */
    public function getTrending(){
        $trending = Redis::zrevrange('trending_threads', 0, 6);
        return array_map('json_decode', $trending);
    }

    /**
     * Record a visit if user visit a thread
     */
    public function recordVisit(){
        Redis::incr("threads.{$this->id}.visits");
        return $this;
    }

    /**
     * Get the thread visits count
     * @return mixed
     */
    public function visits(){
        return Redis::get("threads.{$this->id}.visits") ?: 0;
    }
}
