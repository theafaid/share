<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrendingThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_increament_a_threads_score_every_visit(){

        $trending = Redis::zrevrange('trending_threads', 0, -1);

        Redis::del('trending_threads');

        $thread = create('App\Thread');

        $this->call("GET", "/threads/{$thread->slug}");

        $this->assertCount(3, $trending);

    }
}
