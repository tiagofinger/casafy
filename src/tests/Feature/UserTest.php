<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testListSuccess()
    {
        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->getJson('api/users')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0', fn ($json) =>
                    $json->where('name', 'User 1')
                        ->where('email', 'user1@gmail.com')
                        ->etc()
                )
            );
    }

    public function testCreateSuccess()
    {
        $this->postJson('api/users', [
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                    $json->where('name', 'User 1')
                        ->where('email', 'user1@gmail.com')
                        ->etc()
                    )
            );
    }

    public function testTryCreateWithNameError()
    {
        $this->postJson('api/users', [
            'name' => '',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.name', ['The name field is required.']);
    }

    public function testTryCreateWithEmailError()
    {
        $this->postJson('api/users', [
            'name' => 'User 1',
            'email' => ''
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.email', ['The email field is required.']);
    }

    public function testTryCreateWithEmailDuplicated()
    {
        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->postJson('api/users', [
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.email', ['The email has already been taken.']);
    }

    public function testUpdateSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->putJson('api/users/' . $user->id, [
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                    $json->where('name', 'User 1')
                        ->where('email', 'user1@gmail.com')
                        ->etc()
                )
            );
    }

    public function testTryUpdateWithNameError()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->putJson('api/users/' . $user->id, [
            'name' => '',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.name', ['The name field is required.']);
    }

    public function testTryUpdateWithEmailError()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->putJson('api/users/' . $user->id, [
            'name' => 'User 1',
            'email' => ''
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.email', ['The email field is required.']);
    }

    public function testTryUpdateWithEmailDuplicatedError()
    {
        User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $user = User::factory()->create([
            'name' => 'User 2',
            'email' => 'user2@gmail.com'
        ]);

        $this->putJson('api/users/' . $user->id, [
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.email', ['The email has already been taken.']);
    }

    public function testTryUpdateWithResourceNotFound()
    {
        $this->putJson('api/users/1', [
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ])
            ->assertStatus(404)
            ->assertJsonPath('data.message', 'Resource not found');
    }

    public function testDeleteSuccess()
    {
        $this->deleteJson('api/users/4')
            ->assertStatus(204);
    }
}
