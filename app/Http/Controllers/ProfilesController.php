<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    public function show(User $user){
        return view('profiles.show', [
            'title' => "\"{$user->username}\" Profile",
            'profileUser' => $user,
            'threads' => $user->threads()->paginate(20)
        ]);
    }
}
