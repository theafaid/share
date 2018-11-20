<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(){
        parent::setUp();
        $this->comment = create('App\Comment');
    }
    /** @test */
    function it_has_an_owner(){
        $this->assertInstanceOf('App\User', $this->comment->user);
    }

    /** @test */
    function it_has_an_thread(){
        $this->assertInstanceOf('App\Thread', $this->comment->thread);
    }

    /** @test */
    function a_comment_knows_if_it_was_just_published(){

        $comment = create("App\Comment");

        $this->assertTrue($comment->wasJustPublished());

    }

    /** @test */
    function it_can_detect_all_mentioned_users_in_the_body(){

        $comment = create('App\Comment', ['body' => '@jane and @jone']);
        $this->assertEquals(['jane', 'jone'], $comment->mentionedUsers());

    }

    /** @test */
    function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags(){
        $comment = create('App\Comment', ['body' => '@jane hey']);
        $this->assertEquals('<a href="/profile/jane">@jane</a> hey', $comment->body);
    }

    /** @test */
    function it_knows_if_the_comment_is_best_comment(){

        $this->signIn();

        $thread = create('App\Thread');

        $comment = create('App\Comment', ['thread_id' => $thread->id]);

        $this->assertFalse($comment->isBest);

        $comment->markAsBest();

        $this->assertTrue($comment->isBest);

    }
}
