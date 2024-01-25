<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSeeText('Hello Response');
    }

    public function testHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('Rahmat')
            ->assertSeeText('Meong')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Rahmat')
            ->assertHeader('App', 'Belajar Laravel Dasar');
    }

    public function testView()
    {
        $this->get('/response/type/view')
            ->assertSeeText('Hello Rahmat');
    }

    public function testJson()
    {
        $this->get('/response/type/json')
            ->assertJson(['firstName' => 'Rahmat', 'lastName' => 'Meong']);
    }

    public function testFile()
    {
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testDownload()
    {
        $this->get('/response/type/download')
            ->assertDownload('rahmat.png');
    }
}
