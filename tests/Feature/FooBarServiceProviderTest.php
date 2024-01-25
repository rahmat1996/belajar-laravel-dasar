<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Services\HelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        $this->assertSame($foo1, $foo2);

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        $this->assertSame($bar1, $bar2);

        $this->assertSame($foo1, $bar1->foo);
        $this->assertSame($foo2, $bar2->foo);
    }

    public function testPropertySingletons()
    {
        $helloService1 = $this->app->make(HelloService::class);
        $helloService2 = $this->app->make(HelloService::class);
        $this->assertSame($helloService1, $helloService2);

        $this->assertSame('Halo Rahmat', $helloService1->hello('Rahmat'));
    }

    public function testEmpty()
    {
        $this->assertTrue(true);
    }
}
