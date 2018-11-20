<?php

namespace App\Listeners;

use App\Events\NewCommentAdded;
use App\Notifications\ThreadReceivedNewComment;
//use Illuminate\Queue\InteractsWithQueue;
//use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyThreadSubscribers
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
        // Notify all thread subscriptions users
        foreach($event->comment->thread->subscriptions as $subscription){

            // User must be the creator of the comment to be notified
            if($subscription->user->id != $event->comment->user_id){
                $subscription->user->notify(new ThreadReceivedNewComment($event->comment));
            }
        }
    }
}
