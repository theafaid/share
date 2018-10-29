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

    /** @test */
    function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags(){
        $comment = create('App\Comment', ['body' => '@JaneDoe welcome']);

        $this->assertEquals('<a href="/profile/JaneDoe">@JaneDoe</a> welcome', $comment->body);
    }
}
