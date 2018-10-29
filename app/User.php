<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    protected $appends = ['avatarPath'];
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','avatar'
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
    public function getAvatarPathAttribute(){
        return $this->avatar ? "/storage/{$this->avatar}" : "/design/img/default/avatar.png";
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
