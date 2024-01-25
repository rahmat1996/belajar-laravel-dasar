<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class FacadeTest extends TestCase
{
    public function testConfig()
    {
        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        $this->assertEquals($firstName1, $firstName2);

        // var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        $config = $this->app->make('config');
        $firstName1 = $config->get('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        $this->assertEquals($firstName1, $firstName2);

        //var_dump($config->all());
    }

    public function testFacadeMock()
    {
        Config::shouldReceive('get')->with('contoh.author.first')->andReturn('Meong Keren');
        $firstName = Config::get('contoh.author.first');
        $this->assertEquals('Meong Keren', $firstName);
    }
}
