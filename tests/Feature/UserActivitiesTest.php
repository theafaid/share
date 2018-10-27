<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserActivitiesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_has_activities(){
        $user = create('App\User');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->activities);
    }

//    /** @test */
//    function an_authenticated_user_can_see_specific_user_activities(){
//
//        $user = create('App\User');
//
//        $thread = create('App\Thread', ['user_id' => $user->id]);
//
//        $this->get("/activities/{$user->username}")
//            ->assertSee($thread->title);
//    }

}
