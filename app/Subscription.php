<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use RecordActivity;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subscribed(){
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
