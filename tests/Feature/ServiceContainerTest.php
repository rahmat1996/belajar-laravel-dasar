<?php

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        // $foo = new Foo(); // if not use laravel.
        $foo1 = $this->app->make(Foo::class); // if using laravel
        $foo2 = $this->app->make(Foo::class); // make another foo

        $this->assertEquals('Foo', $foo1->foo());
        $this->assertEquals('Foo', $foo2->foo());
        $this->assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class); // cannot do like this because class Person must have data on constructor
        // $this->assertNotNull($person);

        // using bind to make class with Constructor
        $this->app->bind(Person::class, function ($app) {
            return new Person('Rahmat', 'Meong');
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        $this->assertEquals('Rahmat', $person1->firstName);
        $this->assertEquals('Rahmat', $person2->firstName);
        $this->assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person('Rahmat', 'Meong');
        });

        $person1 = $this->app->make(Person::class); // make new class
        $person2 = $this->app->make(Person::class); // not make new class, using existing class

        $this->assertEquals('Rahmat', $person1->firstName);
        $this->assertEquals('Rahmat', $person2->firstName);
        $this->assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person("Rahmat", "Meong");
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // make new class
        $person2 = $this->app->make(Person::class); // not make new class, using existing class

        $this->assertEquals('Rahmat', $person1->firstName);
        $this->assertEquals('Rahmat', $person2->firstName);
        $this->assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $foo = $this->app->make(Foo::class);
        $bar = $this->app->make(Bar::class);

        $this->assertSame($foo, $bar->foo);
    }

    public function testDependencyInjectionInClosure()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);
        $this->assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        //$this->app->singleton(HelloService::class, HelloServiceIndonesia::class); // for simple object without must using constructor
        $this->app->singleton(HelloService::class, function ($app) {
            return new HelloServiceIndonesia();
        });
        $helloService = $this->app->make(HelloService::class);
        $this->assertEquals('Halo Rahmat', $helloService->hello('Rahmat'));
    }
}
