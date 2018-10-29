<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_fetch_his_recent_comment(){

        $user =create('App\User');

        $comment = create('App\Comment', ['user_id' => $user->id]);

        $this->assertEquals($comment->id, $user->lastComment->id);
    }
}
