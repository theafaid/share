<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use RecordActivity;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function likable(){
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo('App\User');
    }

}
