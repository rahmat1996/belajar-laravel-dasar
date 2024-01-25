<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EnvirontmentTest extends TestCase
{
    public function testGetEnv()
    {
        $youtube = env('YOUTUBE');
        $this->assertEquals('Meong Kucing Lucu', $youtube);
    }

    public function testDefaultEnv()
    {
        $author = env('AUTHOR', 'Rahmat'); // using default value
        $this->assertEquals('Rahmat', $author);
    }
}
