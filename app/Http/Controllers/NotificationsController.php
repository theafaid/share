<?php

namespace App\Http\Controllers;


class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get authenticated user unread notifications
     * @return mixed
     */
    public function index(){
        return auth()->user()->unreadNotifications;
    }

    /**
     * Mark a notification as read
     * @param $id
     */
    public function markAsRead($id){
        auth()->user()->notifications()->find($id)->markAsRead();
    }
}
