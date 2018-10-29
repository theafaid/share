<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Used for searching for a user to mention
     * @return mixed
     */
    public function index(){
        $search = request("username");
        return User::where('username', "LIKE", "$search%")
            ->take(5)
            ->pluck('username');
    }

    /**
     * Upload use avatar
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function storeAvatar(){

        request()->validate(['avatar' => 'required|image|mimes:jpg,jpeg,png']);

        $user = auth()->user();

        $user->update(['avatar' => request()
                ->file('avatar')
                ->storeAs('avatars', $user->username . "_avatar.jpg")
            ]);

        return response([], 204);
    }
}
