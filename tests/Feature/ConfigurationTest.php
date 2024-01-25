<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        $firstName = config('contoh.author.first');
        $lastName = config('contoh.author.last');
        $email = config('contoh.email');
        $web = config('contoh.web');

        $this->assertEquals('Rahmat', $firstName);
        $this->assertEquals('Meong', $lastName);
        $this->assertEquals('test@test.com', $email);
        $this->assertEquals('https://www.test.com', $web);
    }
}
