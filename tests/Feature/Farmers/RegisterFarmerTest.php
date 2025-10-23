<?php

namespace Tests\Feature\Farmers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterFarmerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        Role::create(['name' => 'farmer']);
    }

    public function test_can_register_farmer()
    {
        $farmerData = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => '256' . $this->faker->numerify('#########'),
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->postJson('/api/users/farmers/register', $farmerData);

        $response->assertCreated()
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'phone_number',
                    'created_at',
                    'updated_at',
                ]
            ]);

        $this->assertDatabaseHas('users', [
            'first_name' => $farmerData['first_name'],
            'last_name' => $farmerData['last_name'],
            'phone_number' => $farmerData['phone_number'],
        ]);
    }

    public function test_cannot_register_farmer_with_invalid_data()
    {
        $response = $this->postJson('/api/users/farmers/register', [
            'first_name' => '',
            'last_name' => '',
            'phone_number' => 'invalid',
            'password' => 'short',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['first_name', 'last_name', 'phone_number', 'password']);
    }

    public function test_cannot_register_farmer_with_existing_phone_number()
    {
        $existingUser = User::factory()->create([
            'phone_number' => '256' . $this->faker->numerify('#########')
        ]);

        $response = $this->postJson('/api/users/farmers/register', [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $existingUser->phone_number,
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['phone_number']);
    }
}
