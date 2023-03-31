<?php

namespace Tests\Feature\Api\User;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registerUser()
    {
        $data = [
            'uuid' => 'uuid',
            'name' => $this->faker->firstName(),
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'role_id' => rand(1,2)
        ];
        $response = $this->post('api/v1/user/register',$data);

        $response->assertStatus(200);
    }
}
