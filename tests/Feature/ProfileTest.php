<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_has_a_profile(){

        $user = create('App\User');

        $this->get("/profile/{$user->username}")
            ->assertSee($user->username);
    }

    /** @test */
    function profile_display_all_threads_that_created_by_associated_user(){
        $user  = create('App\User');
        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get("/profile/{$user->username}")
            ->assertSee($thread->title);
    }

}
