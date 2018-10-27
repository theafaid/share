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

    /**
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value){
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
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
