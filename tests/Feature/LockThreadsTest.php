<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function once_locked_a_thread_must_not_receive_new_comments(){
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $comment = make('App\Comment', ['thread_id' => $thread->id]);

        $this->assertEquals($thread->locked, 0);

//        $this->post("/threads/{$thread->slug}/lock")
//            ->assertStatus(204);

        $thread->lock();

        $this->assertEquals($thread->locked, 1);

        $this->post(route('comments.store', $thread->slug), $comment->toArray())
            ->assertStatus(422);

        $this->assertDatabaseMissing('comments', [
            'body' => $comment->body
        ]);
    }
}
