<?php

use App\Models\User;
use App\Models\Vehicle;
use App\Enums\UserRole;
use App\Enums\VehicleStatus;

it('shows all vehicles in the overview regardless of status', function () {
    // Create a user with the 'planner' role so they can pass the middleware
    $user = User::factory()->create([
        'role' => UserRole::PLANNER,
    ]);

    // Create 3 vehicles with different statuses
    $v1 = Vehicle::factory()->create(['status' => VehicleStatus::CONCEPT]);
    $v2 = Vehicle::factory()->create(['status' => VehicleStatus::SCHEDULED]);
    $v3 = Vehicle::factory()->create(['status' => VehicleStatus::COMPLETED]);

    $response = $this->actingAs($user)
        ->get(route('planning.overview'));

    $response->assertStatus(200);

    // Ensure all 3 names appear on the screen
    $response->assertSee($v1->name);
    $response->assertSee($v2->name);
    $response->assertSee($v3->name);

    // Ensure the specific order (Active before Completed)
    $response->assertSeeInOrder([
        $v1->name, // Active (0)
        $v2->name, // Active (0)
        $v3->name  // Completed (1) - Should be last
    ]);
});
