<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

class UserTest extends TestCase
{

    public function testApiRegister()
    {
        $this->deleteUser();

        $data = [
            'email' => 'test@qq.com',
            'name' => 'test',
            'username' => 'test',
            'password' => '12345678',
        ];

        $response = $this->post('api/register', $data);

        $response->assertStatus(Response::HTTP_CREATED)
                 ->assertJsonStructure([ 'access_token', 'token_type']);

        $this->assertDatabaseHas('users', [
            'email'  => $data['email'],
            'name' => $data['name'],
            'username' => $data['username'],
        ]);
    }

    /**
     * Test email login by api.
     *
     * @return void
     */
    public function testApiLoginByEmail()
    {
        $response = $this->post('api/login', [
            'username'    => 'test@qq.com',
            'password' => '12345678'
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([ 'access_token', 'token_type']);
    }

    /**
     * Test for username login by api.
     *
     * @return void
     */
    public function testApiLoginByUsername()
    {
        $response = $this->post('api/login', [
            'username'    => 'test',
            'password' => '12345678'
        ]);

        $response->assertStatus(Response::HTTP_OK)
                 ->assertJsonStructure([ 'access_token', 'token_type']);
    }

    public function testApiEmailLoginFail()
    {
        $response = $this->post('api/login', [
            'username'    => 'test@email.com',
            'password' => 'notlegitpassword'
        ]);

        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function testApiUsernameLoginFail()
    {
        $response = $this->post('api/login', [
            'username'    => 'test',
            'password' => 'notlegitpassword'
        ]);

        $response->assertJsonStructure([
            'errors',
        ]);
    }

    public function testLogout()
    {
        $this->get('api/logout', $this->headers())
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure(['message']);
    }

    public function testUser()
    {
        $url = 'api/user';

        // Test unauthenticated access.
        $this->get($url)
        ->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);

        // Test authenticated access.
        $this->get($url, $this->headers())
        ->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([ 'id', 'name', 'username', 'email']);
    }
}
