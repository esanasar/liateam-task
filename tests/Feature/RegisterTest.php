<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function user_can_register()
    {

        $response = $this->postJson('api/register',[
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => '123456'
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure(['user','token']);

        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com'
        ]);
    }
}
