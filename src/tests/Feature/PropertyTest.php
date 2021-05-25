<?php

namespace Tests\Feature;

use App\Models\Property;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function testListSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->getJson('api/properties')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0', fn ($json) =>
                    $json->where('address', $property->address)
                        ->where('bedrooms', $property->bedrooms)
                        ->where('total_area', $property->total_area)
                        ->where('purchased', $property->purchased)
                        ->where('value', 180000)
                        ->where('discount', $property->discount)
                        ->where('owner_id', $property->owner_id)
                        ->where('expired', $property->expired)
                        ->etc()));
    }

    public function testListWithCreatedDateAfterThreeMonthsSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false,
            'created_at' => '2020-01-01 00:00:00'
        ]);

        Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false,
            'created_at' => '2020-01-01 00:00:00'
        ]);

        Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false,
            'created_at' => '2020-01-01 00:00:00'
        ]);

        $this->getJson('api/properties')
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data.0', fn ($json) =>
                    $json->where('expired', true)
                        ->etc())
                ->has('data.1', fn ($json) =>
                    $json->where('expired', true)
                        ->etc())
                ->has('data.2', fn ($json) =>
                    $json->where('expired', true)
                        ->etc()));
    }

    public function testCreateSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->postJson('api/properties', [
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ])
            ->assertStatus(201)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                    $json->where('address', 'My address')
                        ->where('bedrooms', 1)
                        ->where('bathrooms', 2)
                        ->where('total_area', 150)
                        ->where('purchased', false)
                        ->where('value', 180)
                        ->etc()));
    }

    public function testTryCreateWithError()
    {
        $this->postJson('api/properties/', [
            'address' => null,
            'bedrooms' => null,
            'bathrooms' => null,
            'total_area' => null,
            'purchased' => null,
            'value' => null,
            'discount' => null,
            'owner_id' => null,
            'expired' => null
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.address', ['The address field is required.'])
            ->assertJsonPath('data.message.bedrooms', ['The bedrooms field is required.'])
            ->assertJsonPath('data.message.bathrooms', ['The bathrooms field is required.'])
            ->assertJsonPath('data.message.total_area', ['The total area field is required.'])
            ->assertJsonPath('data.message.purchased', ['The purchased field is required.'])
            ->assertJsonPath('data.message.value', ['The value field is required.'])
            ->assertJsonPath('data.message.discount', ['The discount field is required.'])
            ->assertJsonPath('data.message.owner_id', ['The owner id field is required.'])
            ->assertJsonPath('data.message.expired', ['The expired field is required.']);
    }

    public function testUpdateSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->putJson('api/properties/' . $property->id, [
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ])
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', fn ($json) =>
                    $json->where('address', 'My address')
                        ->where('bedrooms', 1)
                        ->where('bathrooms', 2)
                        ->where('total_area', 150)
                        ->where('purchased', false)
                        ->where('value', 180)
                        ->etc()));
    }

    public function testTryWithOwnerIdIsInvalid()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->putJson('api/properties/' . $property->id, [
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200,
            'discount' => 10,
            'owner_id' => 2,
            'expired' => false
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.owner_id', ['The selected owner id is invalid.']);
    }

    public function testTryUpdateWithError()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My Address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->putJson('api/properties/' . $property->id, [
            'address' => null,
            'bedrooms' => null,
            'bathrooms' => null,
            'total_area' => null,
            'purchased' => null,
            'value' => null,
            'discount' => null,
            'owner_id' => null,
            'expired' => null
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.address', ['The address field is required.'])
            ->assertJsonPath('data.message.bedrooms', ['The bedrooms field is required.'])
            ->assertJsonPath('data.message.bathrooms', ['The bathrooms field is required.'])
            ->assertJsonPath('data.message.total_area', ['The total area field is required.'])
            ->assertJsonPath('data.message.purchased', ['The purchased field is required.'])
            ->assertJsonPath('data.message.value', ['The value field is required.'])
            ->assertJsonPath('data.message.discount', ['The discount field is required.'])
            ->assertJsonPath('data.message.owner_id', ['The owner id field is required.'])
            ->assertJsonPath('data.message.expired', ['The expired field is required.']);
    }

    public function testTryUpdateWithResourceNotFound()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $this->putJson('api/properties/100', [
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ])
            ->assertStatus(404)
            ->assertJsonPath('data.message', 'Resource not found');
    }

    public function testDeleteSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My Address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->deleteJson('api/properties/' . $property->id)
            ->assertStatus(204);
    }

    public function testTryCreateMoreThanThreeTimesWithPurchashedFalse()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        Property::factory()->create([
            'address' => 'My Address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        Property::factory()->create([
            'address' => 'My Address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        Property::factory()->create([
            'address' => 'My Address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->postJson('api/properties', [
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200.000,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ])
            ->assertStatus(400)
            ->assertJsonPath('data.message.purchased', [
                'It is not possible have more than 3 properties with purchased equal false.'
            ]);
    }

    public function testUpdatePurchasedTrueSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->patchJson('api/properties/' . $property->id . '/purchased', [
            'purchased' => true
        ])
            ->assertStatus(204);
    }

    public function testUpdatePurchasedFalseSuccess()
    {
        $user = User::factory()->create([
            'name' => 'User 1',
            'email' => 'user1@gmail.com'
        ]);

        $property = Property::factory()->create([
            'address' => 'My address',
            'bedrooms' => 1,
            'bathrooms' => 2,
            'total_area' => 150,
            'purchased' => false,
            'value' => 200000.00,
            'discount' => 10,
            'owner_id' => $user->id,
            'expired' => false
        ]);

        $this->patchJson('api/properties/' . $property->id . '/purchased', [
            'purchased' => false
        ])
            ->assertStatus(204);
    }
}
