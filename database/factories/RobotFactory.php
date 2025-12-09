<?php

namespace Database\Factories;

use App\Models\Robot;
use App\Enums\VehicleStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class RobotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Robot ' . $this->faker->unique()->numberBetween(1, 100),
        ];
    }
}
