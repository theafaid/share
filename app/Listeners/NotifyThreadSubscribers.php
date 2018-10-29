<?php

namespace App\Listeners;

use App\Events\NewCommentAdded;
use App\Notifications\ThreadReceivedNewComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        foreach($event->comment->thread->subscriptions as $subscription){
            if($subscription->user->id != $event->comment->user_id){
                $subscription->user->notify(new ThreadReceivedNewComment($event->comment));
            }
        }
    }
}
