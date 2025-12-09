<?php

use App\Models\Vehicle;
use App\Models\ScheduleAllocation;
use App\Enums\ScheduleType;
use App\Enums\VehicleStatus;
use Carbon\Carbon;

it('knows when it is completed based on the last allocation slot', function () {
    $now = Carbon::parse('2025-12-09 12:00:00');
    $this->travelTo($now);

    $vehicle = Vehicle::factory()->create(['status' => VehicleStatus::SCHEDULED]);

    ScheduleAllocation::factory()->create([
        'vehicle_id' => $vehicle->id,
        'date' => $now->toDateString(),
        'slot' => 1,
        'type' => ScheduleType::PRODUCTION
    ]);

    $vehicle->refresh();

    expect($vehicle->is_completed)->toBeTrue();
});

it('knows it is NOT completed if the slot is in the future', function () {

    $now = Carbon::parse('2025-12-09 12:00:00');
    $this->travelTo($now);

    $vehicle = Vehicle::factory()->create(['status' => VehicleStatus::SCHEDULED]);

    ScheduleAllocation::factory()->create([
        'vehicle_id' => $vehicle->id,
        'date' => $now->toDateString(),
        'slot' => 4,
        'type' => ScheduleType::PRODUCTION
    ]);

    $vehicle->refresh();

    expect($vehicle->is_completed)->toBeFalse();
});
