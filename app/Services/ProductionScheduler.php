<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\Robot;
use App\Models\ScheduleAllocation;
use App\Enums\ScheduleType;
use App\Enums\VehicleStatus;
use Carbon\Carbon;
use Exception;

class ProductionScheduler
{
    public function schedule(Vehicle $vehicle, string $startDate, int $startSlot): bool
    {
        $duration = $vehicle->total_required_time;

        if ($duration <= 0) {
            throw new Exception('Fout: Tijdsduur is 0.');
        }

        $capableRobots = Robot::all()->filter(fn($r) => $r->canAssemble($vehicle));

        if ($capableRobots->isEmpty()) {
            throw new Exception('Geen geschikte robot gevonden voor dit type voertuig.');
        }

        $assignedRobot = null;
        $schedulePlan = [];

        foreach ($capableRobots as $robot) {
            $schedulePlan = [];
            $currentDate = Carbon::parse($startDate);
            $currentSlot = $startSlot;
            $blocksNeeded = $duration;
            $validRobot = true;

            while ($blocksNeeded > 0) {
                $exists = ScheduleAllocation::where('robot_id', $robot->id)
                    ->where('date', $currentDate->format('Y-m-d'))
                    ->where('slot', $currentSlot)
                    ->exists();

                if ($exists) {
                    $validRobot = false;
                    break;
                }

                $schedulePlan[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'slot' => $currentSlot
                ];

                $blocksNeeded--;
                $currentSlot++;

                // Dagwissel na slot 4
                if ($currentSlot > 4) {
                    $currentSlot = 1;
                    $currentDate->addDay();
                }
            }

            if ($validRobot) {
                $assignedRobot = $robot;
                break;
            }
        }

        if (!$assignedRobot) {
            throw new Exception('Geen robot beschikbaar voor deze opeenvolgende periode.');
        }

        foreach ($schedulePlan as $plan) {
            ScheduleAllocation::create([
                'robot_id'   => $assignedRobot->id,
                'vehicle_id' => $vehicle->id,
                'date'       => $plan['date'],
                'slot'       => $plan['slot'],
                'type'       => ScheduleType::PRODUCTION,
            ]);
        }

        $vehicle->update(['status' => VehicleStatus::SCHEDULED]);

        return true;
    }
}
