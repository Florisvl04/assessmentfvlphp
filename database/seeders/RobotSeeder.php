<?php

namespace Database\Seeders;

use App\Models\Robot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RobotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Robot::create(['name' => 'Robot TwoWheels']);
        Robot::create(['name' => 'Robot HydroBoy']);
        Robot::create(['name' => 'Robot HeavyD']);
    }
}
