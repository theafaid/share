<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
     function it_records_activity_when_a_thread_created(){

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
            'user_id' => 1
        ]);

        $activity = \App\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    function it_records_activity_when_a_comment_created(){
        $this->signIn();

        $comment = create('App\Comment');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_comment',
            'subject_id' => $comment->id,
            'subject_type' => 'App\Comment',
            'user_id' => 1
        ]);
    }
}
