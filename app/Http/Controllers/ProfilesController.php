<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{
    /**
     * User profile page
     * Show profile user threads
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user){
        return view('profiles.show', [
            'title' => "\"{$user->username}\" Profile",
            'profileUser' => $user,
            'threads' => $user->threads()->paginate(20)
        ]);
    }
}
