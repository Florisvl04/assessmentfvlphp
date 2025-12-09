<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Create a user for this vehicle automatically
            'user_id' => User::factory(),
            'name' => 'Vehicle ' . $this->faker->word,
            'status' => VehicleStatus::CONCEPT, // Default status
        ];
    }
}
