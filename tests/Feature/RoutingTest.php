<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get("/about")
            ->assertStatus(200)
            ->assertSeeText("My name Rahmat");
    }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/about');
    }

    public function testFallback()
    {
        $this->get('/notfound')
            ->assertSeeText('404');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText('Product 1');

        $this->get('/products/2')
            ->assertSeeText('Product 2');

        $this->get('/products/1/items/TTT')
            ->assertSeeText('Product 1, Item TTT');

        $this->get('/products/2/items/YYY')
            ->assertSeeText('Product 2, Item YYY');
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/12345')->assertSeeText('Categories : 12345');
        $this->get('/categories/laptop')->assertSeeText('404');
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users/rahmat')->assertSeeText('User : rahmat');
        $this->get('/users/')->assertSeeText('User : 404');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText('Conflict budi');

        $this->get('/conflict/rahmat')
            ->assertSeeText('Conflict Rahmat Meong');
    }

    public function testRouteNamed()
    {
        $this->get('/produk/12345')->assertSeeText('Link : http://localhost/products/12345');
        $this->get('/produk-redirect/12345')->assertRedirect('products/12345');
    }
}
