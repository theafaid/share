<?php

namespace App\Http\Controllers;


class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return auth()->user()->unreadNotifications;
    }

    public function markAsRead($id){
        auth()->user()->notifications()->find($id)->markAsRead();
    }
}
