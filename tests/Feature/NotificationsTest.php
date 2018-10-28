<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_subscriber_must_be_notified_after_subscribed_thread_receive_new_comment(){

        $this->signIn();

        $thread = create('App\Thread');

        $this->post("/threads/{$thread->slug}/subscriptions");

        $thread->addComment("bla bla");

        $this->get('/notifications')
            ->assertStatus(200);

        $this->assertCount(1, auth()->user()->notifications);
    }

    /** @test */
    function a_user_can_clear_a_notification(){
        $this->signIn();


        $thread = create('App\Thread');

        $thread->subscribe(auth()->id());

        $thread->addComment("bla bla");

        $userNotifications = auth()->user()->notifications;

        $this->assertCount(1, $userNotifications);

        $userNotificationId = $userNotifications->first()->id;

        $this->delete("/notifications/{$userNotificationId}");

        $this->assertNotNull('read_at', $userNotifications->first());
    }
}
