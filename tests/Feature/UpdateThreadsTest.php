<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function a_thread_can_be_updated(){
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $thread['title'] = 'new title';
        $thread['body']  = $newBody = str_random(255);

        $this->patch(route("threads.update", $thread->slug), $thread->toArray());

        $this->assertEquals('new title', $thread->fresh()->title);
        $this->assertEquals($newBody, $thread->fresh()->body);

    }

    /** @test */
    function a_thread_requires_a_title_and_body_to_be_updated(){
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->patch(route("threads.update", $thread->slug), [])
            ->assertSessionHasErrors(['title', 'body']);

        $this->patch(route("threads.update", $thread->slug), ['title' => 'new title'])
            ->assertSessionHasErrors('body');

        $this->patch(route("threads.update", $thread->slug), ['body' => str_random(255)])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function only_creator_of_the_thread_can_update_it(){
        $this->signIn();
        $user = create('App\User');
        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->patch(route("threads.update", $thread->slug), [
            'title' => 'new title',
            'body'  => str_random(255)
        ])->assertStatus(403)
            ->assertJson(['message' => 'unauthorized']);

        $this->assertEquals($thread->title, $thread->fresh()->title);
        $this->assertEquals($thread->body, $thread->fresh()->body);
    }

}
