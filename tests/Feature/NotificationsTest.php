<?php

namespace Tests\Feature;

use App\Notifications\ThreadReceivedNewComment;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_subscriber_must_be_notified_after_subscribed_thread_receive_new_comment(){

        Notification::fake();

        $this->signIn();

        $thread = create('App\Thread');

        $this->post("/threads/{$thread->slug}/subscriptions");

        $user = create('App\User');

        $thread->addComment("bla bla", $user->id);

        Notification::assertSentTo(auth()->user(), ThreadReceivedNewComment::class);
    }

    /** @test */
    function a_user_can_clear_a_notification(){

        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe(auth()->id());

        $user = create('App\User');

        $thread->addComment("bla bla", $user->id);

        $userNotifications = auth()->user()->notifications;

        $this->assertCount(1, $userNotifications);

        $userNotificationId = $userNotifications->first()->id;

        $this->delete("/notifications/{$userNotificationId}");

        $this->assertNotNull('read_at', $userNotifications->first());
    }
}
