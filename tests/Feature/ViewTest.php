<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello Rahmat');

        $this->get('/hello-again')
            ->assertSeeText('Hello Rahmat');
    }

    public function testNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('World Rahmat');
    }

    // test for view template such as template for email
    public function testTemplate()
    {
        $this->view('hello', ['name' => 'Rahmat'])
            ->assertSeeText('Hello Rahmat');

        $this->view('hello.world', ['name' => 'Rahmat'])
            ->assertSeeText('World Rahmat');
    }
}
