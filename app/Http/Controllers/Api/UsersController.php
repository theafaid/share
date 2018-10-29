<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
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
}
