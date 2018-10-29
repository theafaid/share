<?php

namespace App\Http\Controllers;

use App\User;

class ProfilesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show']]);
    }

    public function index(){
        return view('profiles.index');
    }

    public function updateProfileData(){
        $data = request()->validate([
            'username' => 'required|string|max:255|min:6|unique:users,username,'. auth()->id(),
            'password' => 'sometimes|nullable|string|min:6|max:255'
        ]);


        auth()->user()->username = $data['username'];
        if(request()->has('password') && request('password') != ''){
            auth()->user()->password = bcrypt($data['password']);
        }
        auth()->user()->save();

        session()->flash('success', 'Your Profile Updated Successfully');
        return back();
    }
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
