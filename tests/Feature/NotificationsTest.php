<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_subscriber_must_be_notified_after_subscribed_thread_receive_new_comment(){
        $thread = create('App\Thread');
        $user = create('App\User');
        $thread->subscribe($user->id);

        create('App\Comment', ['thread_id' => $thread->id]);
        $this->assertCount(1, $user->notifications);
    }
}
