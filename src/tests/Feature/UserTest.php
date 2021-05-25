<?php

namespace Tests\Feature;

use App\Models\Property;
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
                        ->etc()));
    }

    public function testListUserPropertiesSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        Property::factory()->create([
            'address' => 'My address 1',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        Property::factory()->create([
            'address' => 'My address 2',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->getJson('api/users/' . $user->id . '/properties')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.user', fn ($json) =>
                    $json->where('name', 'User 1')
                        ->where('email', 'user1@gmail.com')
                        ->etc()
                )
                ->has('data.properties.0', fn ($json) =>
                    $json->where('address', 'My address 1')
                        ->where('bedrooms', 1)
                        ->where('bathrooms', 2)
                        ->where('total_area', 150)
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
                        ->etc()));
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
                        ->etc()));
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
