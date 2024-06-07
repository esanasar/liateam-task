<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_can_login()
    {

        $user = User::factory()->create([
            'name' => 'test',
            'email' => 'test@gmail.com',
            'password' => bcrypt($password = '123456'),
        ]);

        $response = $this->postJson('api/login',[
            'email' => 'test@gmail.com',
            'password' => $password
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }
}
