<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class URLGenerationTest extends TestCase
{
    public function testURLCurrent()
    {
        $this->get('/url/current?name=Rahmat')
            ->assertSeeText('url/current?name=Rahmat');
    }

    public function testNamed()
    {
        $this->get('/redirect/named')
            ->assertSeeText('redirect/name/Rahmat');
    }

    public function testAction()
    {
        $this->get('/url/action')->assertSeeText('/form');
    }
}
