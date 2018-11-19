<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(){
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */

    function it_has_an_owner(){
        $this->assertInstanceOf('App\User', $this->thread->user);
    }

    /** @test */
    function a_thread_belong_to_a_channel(){
        $this->assertInstanceOf('App\Channel', $this->thread->channel);
    }

    /** @test */
    function a_thread_has_comments(){
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->comments);
    }

    /** @test */
    function a_thread_can_add_comment(){

        $this->signIn();

        $this->thread->addComment('foobar');

        $this->assertCount(1, $this->thread->comments);
    }

    /** @test */
    function a_thread_can_check_if_the_authenticated_user_has_read_all_comments(){
          $this->signIn();

            $thread = create('App\Thread');

            $this->assertTrue($thread->hasUpdatesFor());
    }

    /** @test */
    function it_records_each_visit(){

        $thread = make('App\Thread', ['id' => 1]);

        Redis::del("threads.{$thread->id}.visits");

        $thread->recordVisit();

        $this->assertEquals(1, $thread->visits());

        $thread->recordVisit();

        $this->assertEquals(2, $thread->visits());

    }

    /** @test */
    function it_must_have_a_unique_slug(){

        $this->signIn();

        $thread = create('App\Thread', ['slug' => 'hello-and-welcome']);

        $this->assertEquals('hello-and-welcome', $thread->slug);

        $thread = create('App\Thread', ['slug' => 'hello-and-welcome']);

        $this->assertEquals('hello-and-welcome_' . time(), $thread->slug);

    }

    /** @test */
    function it_can_be_locked(){

        $thread = create('App\Thread');

        $this->assertEquals($thread->locked, 0);

        $thread->lock();

        $this->assertEquals($thread->locked, 1);

    }

    /** @test */
    function it_can_be_unlocked(){

        $thread = create('App\Thread', ['locked' => true]);

        $thread->unlock();

        $this->assertEquals($thread->locked, 0);
    }
}
