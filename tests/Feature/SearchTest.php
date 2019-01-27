<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        config(['scout.driver' => 'algolia']);
    }

    /** @test */
    function a_user_can_search_for_a_thread(){
        $search = "foobar";

        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "this is just a {$search}"], 2);

        do {
            sleep(.5);
            $result = $this->getJson("/search?q={$search}")->json();
        } while(empty($result));

        $this->assertCount(0, $result['data']);

        Thread::latest()->take(4)->unsearchable();
    }
}
