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

        $this->post(route('threads.lock', $thread->slug))
            ->assertStatus(204);

        $this->assertEquals($thread->fresh()->locked, 1);

        $this->post(route('comments.store', $thread->slug), $comment->toArray())
            ->assertStatus(422);

        $this->assertDatabaseMissing('comments', [
            'body' => $comment->body
        ]);
    }

    /** @test */
    function once_unlocked_a_thread_must_receive_new_comments(){
        $this->signIn();

        $thread  = create('App\Thread', ['user_id' => auth()->id()]);
        $comment = make('App\Comment');

        $this->post(route('threads.lock', $thread->slug));

        $this->assertEquals(1, $thread->fresh()->locked);

        $this->post(route('comments.store', $thread->slug), $comment->toArray())
            ->assertStatus(422);

        $this->assertDatabaseMissing('comments', [
            'body' => $comment->body
        ]);

        $this->post(route('threads.lock', $thread->slug));

        $this->assertEquals(0, $thread->fresh()->locked);

        $this->post(route('comments.store', $thread->slug), $comment->toArray());

        $this->assertCount(1, $thread->comments);

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body
        ]);
    }

    /** @test */
    function only_thread_creator_can_lock_or_unlock_the_thread(){

        $user = create('App\User');

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->post(route('threads.lock', $thread->slug))
            ->assertStatus(403);

        $this->assertEquals(0, $thread->fresh()->locked);
    }

}
