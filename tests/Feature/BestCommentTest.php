<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BestCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_thread_creator_can_mark_any_comment_as_best_comment(){

        $this->signIn();

        $thread = create('App\Thread', ['best_comment_id' => 1, 'user_id' => auth()->id()]);

        $comment = create('App\Comment', ['thread_id' => $thread->id]);

        $this->post("/comments/{$comment->id}/best")
            ->assertStatus(204);

        $this->assertEquals($comment->id, $thread->best_comment_id);
    }

    /** @test */
    function a_thread_creator_can_remove_a_best_comment(){

        $this->signIn();

        $thread = create('App\Thread', ['best_comment_id' => 1, 'user_id' => auth()->id()]);

        $comment = create('App\Comment', ['thread_id' => $thread->id]);

        $this->post("/comments/{$comment->id}/best");

        $this->assertEquals($comment->id, $thread->best_comment_id);

        $this->delete("/comments/{$comment->id}/best")
            ->assertStatus(204);

        $this->assertEquals(1, $thread->best_comment_id);
    }

    /** @test */
    function only_thread_creator_can_add_best_comment(){
        $this->signIn();

        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $comment = create('App\Comment', ['thread_id' => $thread->id]);

        $this->post("/comments/{$comment->id}/best")
            ->assertStatus(403);

        $this->assertFalse($comment->isBest);

    }

    /** @test */
    function only_thread_creator_can_remove_best_comment(){
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $comment = create('App\Comment', ['thread_id' => $thread->id]);

        $this->post("/comments/{$comment->id}/best")
            ->assertStatus(204);

        $user = create('App\User');

        $this->signIn($user);

        $this->delete("/comments/{$comment->id}/best")
            ->assertStatus(403);
    }
}
