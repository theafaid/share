<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function it_checks_for_invalid_keywords(){

      $spam = new Spam();

      $this->assertFalse($spam->detect("Innocent Comment"));

        $this->expectException('Exception');

        $spam->detect('shit');
        $spam->detect('idiot');

    }

    /** @test */
    function it_checks_for_key_held_down(){

        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('11111');

    }
}
