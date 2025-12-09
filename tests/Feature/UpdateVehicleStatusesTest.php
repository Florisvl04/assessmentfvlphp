<?php

use App\Models\Vehicle;
use App\Models\ScheduleAllocation;
use App\Enums\VehicleStatus;
use App\Enums\ScheduleType;
use Carbon\Carbon;

it('moves a scheduled vehicle to IN_PRODUCTION if currently busy', function () {
    // 1. Set "Real Time" to 11:00 AM
    $fakeNow = Carbon::parse('2025-05-10 11:00:00');
    $this->travelTo($fakeNow);

    $vehicle = Vehicle::factory()->create(['status' => VehicleStatus::SCHEDULED]);

    // 2. Schedule it from 10:00 to 12:00 (Slot 2) TODAY
    // Since it is 11:00 now, it is right in the middle.
    ScheduleAllocation::factory()->create([
        'vehicle_id' => $vehicle->id,
        'date' => $fakeNow->toDateString(),
        'slot' => 2, // Starts 10:00, Ends 12:00
        'type' => ScheduleType::PRODUCTION
    ]);

    // 3. Run the command
    $this->artisan('app:update-vehicle-statuses')
        ->assertExitCode(0);

    // 4. Assert status changed
    expect($vehicle->fresh()->status)->toBe(VehicleStatus::IN_PRODUCTION);
});

it('moves a vehicle to COMPLETED if the time has passed', function () {
    // 1. Set time to late afternoon
    $fakeNow = Carbon::parse('2025-05-10 17:00:00');
    $this->travelTo($fakeNow);

    $vehicle = Vehicle::factory()->create(['status' => VehicleStatus::IN_PRODUCTION]);

    // 2. Schedule was for earlier today (Slot 1, Ends 10:00)
    ScheduleAllocation::factory()->create([
        'vehicle_id' => $vehicle->id,
        'date' => $fakeNow->toDateString(),
        'slot' => 1,
        'type' => ScheduleType::PRODUCTION
    ]);

    // 3. Run command
    $this->artisan('app:update-vehicle-statuses');

    expect($vehicle->fresh()->status)->toBe(VehicleStatus::COMPLETED);
});
