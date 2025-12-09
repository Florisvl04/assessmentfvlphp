<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;
use App\Enums\VehicleStatus;
use App\Enums\ScheduleType; // Make sure to import this
use Carbon\Carbon;

class UpdateVehicleStatuses extends Command
{
    protected $signature = 'app:update-vehicle-statuses';
    protected $description = 'Update vehicle status to IN_PRODUCTION or COMPLETED based on time.';

    public function handle()
    {
        $now = Carbon::now();

        // 1. Get vehicles that are active (Scheduled or In Production)
        $vehicles = Vehicle::whereIn('status', [VehicleStatus::SCHEDULED, VehicleStatus::IN_PRODUCTION])
            ->with(['allocations'])
            ->get();

        foreach ($vehicles as $vehicle) {
            // Filter only production allocations
            $allocations = $vehicle->allocations->where('type', ScheduleType::PRODUCTION);

            if ($allocations->isEmpty()) {
                continue;
            }

            // Find start time
            $firstBlock = $allocations->sortBy(function ($alloc) {
                return $alloc->date->format('Ymd') . $alloc->slot;
            })->first();

            $startTimeString = match($firstBlock->slot) {
                1 => '08:00:00',
                2 => '10:00:00',
                3 => '12:00:00',
                4 => '14:00:00',
                default => '08:00:00',
            };
            $startMoment = $firstBlock->date->copy()->setTimeFromTimeString($startTimeString);


            // Find end time
            $lastBlock = $allocations->sortByDesc(function ($alloc) {
                return $alloc->date->format('Ymd') . $alloc->slot;
            })->first();

            $endTimeString = match($lastBlock->slot) {
                1 => '10:00:00',
                2 => '12:00:00',
                3 => '14:00:00',
                4 => '16:00:00',
                default => '17:00:00',
            };
            $endMoment = $lastBlock->date->copy()->setTimeFromTimeString($endTimeString);

            // Case 1: Totally Finished
            if ($now->greaterThan($endMoment)) {
                if ($vehicle->status !== VehicleStatus::COMPLETED) {
                    $vehicle->update(['status' => VehicleStatus::COMPLETED]);
                    $this->info("Vehicle {$vehicle->id} -> COMPLETED");
                }
            }
            // Case 2: In the Middle (Started but not finished)
            elseif ($now->greaterThan($startMoment)) {
                if ($vehicle->status !== VehicleStatus::IN_PRODUCTION) {
                    $vehicle->update(['status' => VehicleStatus::IN_PRODUCTION]);
                    $this->info("Vehicle {$vehicle->id} -> IN_PRODUCTION");
                }
            }
        }

        $this->info('Status update check finished.');
    }
}
