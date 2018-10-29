<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Storage;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function member_must_provide_valid_image(){

        $this->signIn();

        $response = $this->json('POST', "/api/users/avatar", [
            'avatar' => 'not image'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    function member_can_add_avatar(){

        $this->signIn();

        $user = auth()->user();

        Storage::fake('public');

        $response = $this->json('POST', "/api/users/avatar", [
            'avatar' => UploadedFile::fake()->image($user->username . "_avatar.jpg")
        ]);

        Storage::disk('public')->assertExists('avatars/'.$user->username . "_avatar.jpg");
    }
}
