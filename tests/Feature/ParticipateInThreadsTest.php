<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInThreadsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->comment = make('App\Comment');
        $this->thread  = create('App\Thread');
    }

    /** @test */
    function unauthenticated_user_may_not_add_comment_in_forum_threads(){

        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post($this->path('comments'), []);

    }

   /** @test */
   function an_authenticated_user_may_participate_in_forum_threads(){


        $this->signIn();

        $this->post($this->path('comments'), $this->comment->toArray());

        $this->get($this->path())
            ->assertSee($this->comment->body);
   }

    /** @test */
    function a_comment_requires_a_body(){
        $this->withExceptionHandling()->signIn();
        $this->comment['body'] = null;
        $this->post($this->path("comments"), $this->comment->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_authenticated_user_can_only_delete_his_comment(){
        $this->signIn();

        $comment = create('App\Comment', ['user_id' => auth()->id()]);
        $response = $this->json('DELETE', "/comments/{$comment->id}");
        $response->assertStatus(204);

        $comment = create('App\Comment');
        $response = $this->json('DELETE', "/comments/{$comment->id}");
        $response->assertStatus(403);
    }

    protected function path($url = null){
        return "/threads/{$this->thread->slug}/{$url}";
    }
}
