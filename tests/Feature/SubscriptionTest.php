<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function unauthenticated_user_cannot_subscribe_to_thread(){
        $this->withExceptionHandling();
        $thread = create('App\Thread');
        $response = $this->post("/threads/{$thread->slug}/subscriptions");
        $response->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_subscribe_to_a_thread(){
        $this->signIn();
        $thread = create('App\Thread');
        $response = $this->post("/threads/{$thread->slug}/subscriptions");

        $response->assertStatus(204);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => auth()->id(),
            'subscribed_id' => $thread->id,
            'subscribed_type' => get_class($thread)
        ]);

    }

    /** @test */
    function an_authenticated_user_can_subscribe_to_thread_only_once(){
        $thread = create('App\Thread');
        // the creator of the thread now has been subscribed
        // to his thread. and he cannot subscribe again
        $this->post("/threads/{$thread->slug}/subscriptions");
        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    function an_authenticated_user_can_unsubscribe_to_thread(){
        $this->signIn();
        $thread = create('App\Thread');

        $this->post("/threads/{$thread->slug}/subscriptions");
        $this->delete("/threads/{$thread->slug}/subscriptions");

        // only the thread owner is subscribed
        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    function a_creator_of_thread_must_subscribed_to_his_thread(){
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $this->assertDatabaseHas("subscriptions", [
            'user_id' => $thread->user_id,
            'subscribed_id' => $thread->id,
            'subscribed_type' => get_class($thread)
        ]);
    }
}
