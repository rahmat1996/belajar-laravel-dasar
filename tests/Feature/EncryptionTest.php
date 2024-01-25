<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrypt = Crypt::encrypt('Rahmat');
        var_dump($encrypt);
        $decrypt = Crypt::decrypt($encrypt);
        var_dump($decrypt);
        $this->assertEquals('Rahmat', $decrypt);
    }
}
