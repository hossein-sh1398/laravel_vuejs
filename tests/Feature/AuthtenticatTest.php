<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthtenticatTest extends TestCase
{
    public function test_validate_register()
    {
        $this->withoutExceptionHandling();
        $response = $this->postJson('/api/v1/register');
       
        $response->assertStatus(422);
    }

    // public function test_insert_user()
    // {
    //     $this->withoutExceptionHandling();

    //     $response = $this->postJson('/api/v1/register', [
    //         'name' => 'hosseinf',
    //         'email' => 'hosseinskhirinegad98f@gmail.com',
    //         'password' => '1234567890'
    //     ]);

    //     $response->assertStatus(201);
    // }
}
