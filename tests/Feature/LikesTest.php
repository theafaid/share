<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_can_like_any_comment()
    {

        $this->signIn();
        $comment = create('App\Comment');

        $this->post("/comments/{$comment->id}/likes");
        $this->assertCount(1, $comment->likes);
    }

    /** @test */
    function unauthenticated_user_cannot_like_anything()
    {
        $this->withExceptionHandling();
        $this->post("/comments/1/likes")
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_may_only_like_a_comment_once()
    {
        $this->signIn();
        $comment = create('App\Comment');
        try{
            $this->post("/comments/{$comment->id}/likes");
            $this->post("/comments/{$comment->id}/likes");
            $this->assertCount(1, $comment->likes);
            // assert count to be the same count 3
        }catch(\Exception $ex){
            $this->fail("Cannot Like anything more than once !!");
        }
    }

    /** @test */
    function an_authenticated_user_may_only_unlike_a_comment_if_comment_is_liked_by_him(){
        $this->signIn();
        $comment = create('App\Comment');
        $this->post("/comments/{$comment->id}/likes");
        $this->delete("/comments/{$comment->id}/likes");
        $this->assertCount(0, $comment->likes);
    }
}

