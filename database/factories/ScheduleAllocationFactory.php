<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Models\Robot;
use App\Enums\ScheduleType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleAllocationFactory extends Factory
{
    public function definition(): array
    {
        return [
            // If no vehicle provided, make one
            'vehicle_id' => Vehicle::factory(),
            // If no robot provided, make one (or pick existing)
            'robot_id' => Robot::first()?->id ?? Robot::factory(),
            'date' => now(),
            'slot' => 1,
            'type' => ScheduleType::PRODUCTION,
        ];
    }
}
