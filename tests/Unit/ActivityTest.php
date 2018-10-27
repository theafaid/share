<?php

namespace Tests\Unit;

use Carbon\Carbon;
use App\Activity;
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

        $activity = Activity::first();

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

    /** @test */
    function it_fetches_a_activities_feed_for_any_user(){

        $user = create('App\User');
        $this->actingAs($user);

        create('App\Thread', ['user_id' => $user->id]);

        $feed = Activity::feed($user);

        $this->assertTrue($feed->keys()->
            contains(Carbon::now()->format('Y-m-d | H:i')
        ));

    }

}
