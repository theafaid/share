<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function mentiond_users_in_a_comment_are_notified(){

        $john = create('App\User', ['username' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create('App\User', ['username' => 'JaneDoe']);

        $thread = create('App\Thread');

        $comment = make('App\Comment', [
            'body' => '@JaneDoe welcome'
        ]);

        $this->json('POST', "/threads/{$thread->slug}/comments", $comment->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
