<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $appends = ['imagePath'];
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','image'
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return "username";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads(){
        return $this->hasMany('App\Thread');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities(){
        return $this->hasMany('App\Activity');
    }

    /**
     * @return string
     */
    public function getImagePathAttribute(){
        return $this->image ? "/storage/{$this->image}" : "/design/img/default/avatar.png";
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastComment(){
        return $this->hasOne('App\Comment')->latest();
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];
}
