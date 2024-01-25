<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Rahmat')->assertSeeText('Hello Rahmat');
        $this->post('/input/hello', ['name' => 'Rahmat'])->assertSeeText('Hello Rahmat');
    }

    public function testNestedInput()
    {
        $this->post('/input/hello/first', ['name' => [
            'first' => 'Rahmat'
        ]])->assertSeeText('Hello Rahmat');
    }

    public function testInputAll()
    {
        $this->post(
            '/input/hello/input',
            [
                'name' => [
                    'first' => 'Rahmat',
                    'last' => 'Meong'
                ]
            ]
        )->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('Rahmat')
            ->assertSeeText('last')
            ->assertSeeText('Meong');
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            'products' => [
                ['name' => 'Apple Iphone', 'price' => 1200],
                ['name' => 'Samsung Phone', 'price' => 500]
            ]
        ])->assertSeeText('Samsung Phone')->assertSeeText('Apple Iphone')->assertDontSee(1200)->assertDontSee(500);
    }

    public function testInputQuery()
    {
        $this->get('/input/hello/query?name=Rahmat&debug=true')
            ->assertSeeText('Rahmat')->assertSeeText('true');
    }

    public function testInputType()
    {
        $this->post('input/type', [
            'name' => 'Rahmat',
            'married' => 'true',
            'birth_date' => '1990-10-23'
        ])->assertSeeText('Rahmat')->assertSeeText('true')->assertSeeText('1990-10-23');
    }

    public function testFilterOnly()
    {
        $this->post('input/filter/only', [
            "name" => [
                "first" => "Rahmat",
                "middle" => "Kucing",
                "last" => "Meong"
            ]
        ])->assertSeeText('Rahmat')->assertSeeText('Meong')->assertDontSeeText('Kucing');
    }

    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [
            "username" => "rahmat",
            "admin" => "true",
            "password" => "12345"
        ])->assertSeeText("rahmat")->assertSeeText("12345")->assertDontSeeText("admin");
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "rahmat",
            "admin" => "true",
            "password" => "12345"
        ])->assertSeeText("rahmat")->assertSeeText("12345")->assertSeeText("admin")->assertSeeText("false");
    }
}
