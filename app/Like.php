<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use RecordActivity;
    protected $guarded = [];

    public function likable(){
        return $this->morphTo();
    }
}
