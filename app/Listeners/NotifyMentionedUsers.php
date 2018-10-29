<?php

namespace App\Listeners;

use App\Events\NewCommentAdded;
use App\Notifications\YouWereMentioned;
use App\User;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewCommentAdded  $event
     * @return void
     */
    public function handle(NewCommentAdded $event)
    {
        // if body contais @username > it will catched
        preg_match_all('/\@([\w]+)/', $event->comment->body, $matches);

        foreach($matches[1] as $username){

            $user = User::where('username', $username)->first();
            // user must be exists and cannot be the same user who created the comment
            if($user && $username != $event->comment->user->username){
                $user->notify(new YouWereMentioned($event->comment));
            }
        }
    }
}
