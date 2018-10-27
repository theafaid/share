<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
class ActivitiesController extends Controller
{
    public function show(User $user){

        $activities = Activity::feed($user);

        return view('activities.index', [
            'title' => "{$user->username} Activities",
            'user' => $user,
            'userActivities' => $activities
        ]);
    }
}
