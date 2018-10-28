<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(){
        parent::setUp();
        
        $this->thread = create('App\Thread');
    }

   /** @test */
   function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);

    }

    /** @test */
     function a_user_can_read_a_single_thread(){
        $response = $this->get("/threads/{$this->thread->slug}");
        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_read_comments_that_are_associated_with_a_thread(){
        $comment = factory('App\Comment')->create(['thread_id' => $this->thread->id]);
        $response = $this->get("/threads/{$this->thread->slug}/comments");
        $response->assertSee($comment->body);
    }

    /** @test */
    function a_user_can_filter_threads_by_channel(){
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get("/channels/{$channel->slug}")
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username(){

        $this->signIn();
        $threadBySpesificUser = create('App\Thread', ['user_id' => auth()->id()]);
        $threadByOther = create('App\Thread');

        $this->get("/threads?by=" . auth()->user()->username)
            ->assertSee($threadBySpesificUser->title)
            ->assertDontSee($threadByOther->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_unanswered(){
        $thread = create('App\Thread');
        $this->get("/threads?filter=unanswered")
            ->assertSee($thread->title);
    }

}
