<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    public function testCreateCookie()
    {
        $this->get('/cookie/set')
            ->assertSeeText('Hello Cookie')
            ->assertCookie('User-Id', 'rahmat')
            ->assertCookie('Is-Member', 'true');
    }

    public function testGetCookie()
    {
        $this->withCookie('User-Id', 'rahmat')
            ->withCookie('Is-Member', 'true')
            ->get('/cookie/get')
            ->assertJson(
                [
                    'userId' => 'rahmat',
                    'isMember' => 'true'
                ]
            );
    }

    public function testClearCookie()
    {
        $this->withCookie('User-Id', 'rahmat')
            ->withCookie('Is-Member', 'true')
            ->get('/cookie/clear')
            ->assertCookie('User-Id', '')
            ->assertCookie('Is-Member', '');
    }
}
