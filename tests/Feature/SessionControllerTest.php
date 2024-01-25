<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText('OK')
            ->assertSessionHas('userId', 'rahmat')
            ->assertSessionHas('isMember', true);
    }

    public function testGetSessionSuccess()
    {
        $this->withSession([
            'userId' => 'rahmat',
            'isMember' => "true"
        ])->get('/session/get')
            ->assertSeeText('rahmat')->assertSeeText('true');
    }

    public function testGetSessionFailed()
    {
        $this->withSession([])
            ->get('/session/get')
            ->assertSeeText('guest')->assertSeeText('false');
    }
}
