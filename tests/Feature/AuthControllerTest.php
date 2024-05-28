<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_login_failure()
    {
        $response = $this->postJson('/api/login', [
            'login' => 'test',
            'password' => 'foo-bar-baz'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'failure',
            ]);
    }

    public function test_login_success()
    {
        $response = $this->postJson('/api/login', [
            'login' => 'FOO_1',
            'password' => 'foo-bar-baz'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ]);

        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_login_with_unsupported_prefix()
    {
        $response = $this->postJson('/api/login', [
            'login' => 'XYZ_1',
            'password' => 'foo-bar-baz'
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'status' => 'failure',
                'message' => 'No authentication adapter found for the provided login.'
            ]);
    }
}
