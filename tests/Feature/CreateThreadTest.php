<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->thread = make('App\Thread');
    }

    /** @test */
    function unauthenticated_user_cannot_add_new_thread(){
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post("/threads", $this->thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_add_new_thread(){

        $this->signIn();

        $this->post("/threads", $this->thread->toArray());
        $this->get("/threads/{$this->thread->slug}")
            ->assertSee($this->thread->title);
    }

    /** @test */
    function unauthenticated_user_cannot_see_create_thread_page(){
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function a_thread_requires_a_title(){
        $this->withExceptionHandling()->signIn();
        $this->thread['title'] = null;
        $this->post('/threads', $this->thread->toArray())
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body(){
        $this->withExceptionHandling()->signIn();
        $this->thread['body'] = null;
        $this->post('/threads', $this->thread->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel(){
        $this->withExceptionHandling()->signIn();
        factory('App\Channel', 2)->create();
        $this->thread['channel_id'] = "invalid channel";
        $this->post('/threads', $this->thread->toArray())
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    function a_thread_can_be_deleted_by_the_thread_owner(){
        $user = $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $comment = create('App\Comment', ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', "/threads/{$thread->slug}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing("threads", ['id' => $thread->id]);
        $this->assertDatabaseMissing("comments", ['id' => $comment->id]);
    }

    /** @test */
    function unauthenticated_users_cannot_delete_threads(){
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete("/threads/{$thread->slug}")
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete("/threads/{$thread->slug}")
            ->assertStatus(403);
    }


}
