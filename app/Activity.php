<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject(){
        return $this->morphTo();
    }

    /**
     * Get specific user activities
     * @param $user
     * @return mixed
     */
    public static function feed($user){
        return static::where('user_id', $user->id)
            ->with('subject')
            ->latest()
            ->take(7)
            ->get()
            ->groupBy(function($activity){
                return $activity->created_at->format('Y-m-d | H:i');
            });
    }
}
