<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvirontmentTest extends TestCase
{
    public function testAppEnv()
    {
        var_dump(App::environment()); // to show environment actived

        // to check is environtment actived
        if (App::environment('testing')) {
            $this->assertTrue(true);
        }
    }
}
