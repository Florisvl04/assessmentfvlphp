<?php

namespace App\Http\Controllers;

use App\Models\Robot;
use App\Models\Vehicle;
use App\Models\ScheduleAllocation;
use App\Enums\ScheduleType;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlannerController extends Controller
{
    public function index()
    {
        $startDate = Carbon::today();
        $endDate = Carbon::today()->addDays(4);

        $allocations = ScheduleAllocation::with(['robot', 'vehicle'])
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $unscheduledVehicles = Vehicle::whereIn('status', [VehicleStatus::CONCEPT, VehicleStatus::PENDING])
            ->with('modules')
            ->get();

        $totalBacklog = $unscheduledVehicles->sum(function ($vehicle) {
            return $vehicle->total_required_time;
        });

        $robots = Robot::all();

        return view('planner.index', [
            'dates' => \Carbon\CarbonPeriod::create($startDate, $endDate),
            'slots' => [1, 2, 3, 4],
            'allocations' => $allocations,
            'robots' => $robots,
            'vehicles' => $unscheduledVehicles,
            'required_time' => $totalBacklog,
        ]);
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'robot_id' => 'required|exists:robots,id',
            'date' => 'required|date|after_or_equal:today',
            'slot' => 'required|integer|min:1|max:4',
        ]);

        $exists = ScheduleAllocation::where('robot_id', $validated['robot_id'])
            ->where('date', $validated['date'])
            ->where('slot', $validated['slot'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['msg' => 'Deze robot is al bezet op dit tijdstip.']);
        }

        ScheduleAllocation::create([
            'robot_id' => $validated['robot_id'],
            'date' => $validated['date'],
            'slot' => $validated['slot'],
            'type' => ScheduleType::MAINTENANCE,
        ]);

        return back()->with('success', 'Onderhoud ingepland.');
    }

    public function storeProduction(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'date' => 'required|date|after_or_equal:today',
            'start_slot' => 'required|integer|min:1|max:4',
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        $duration = $vehicle->required_time;

        $capableRobots = Robot::all()->filter(function ($robot) use ($vehicle) {
            return $robot->canAssemble($vehicle);
        });

        if ($capableRobots->isEmpty()) {
            return back()->withErrors(['msg' => 'Er is geen robot geschikt om dit specifieke voertuig te bouwen.']);
        }

        $assignedRobot = null;

        foreach ($capableRobots as $robot) {
            $isFree = true;

            for ($i = 0; $i < $duration; $i++) {
                $checkSlot = $validated['start_slot'] + $i;

                if ($checkSlot > 4) {
                    $isFree = false;
                    break;
                }

                $collision = ScheduleAllocation::where('robot_id', $robot->id)
                    ->where('date', $validated['date'])
                    ->where('slot', $checkSlot)
                    ->exists();

                if ($collision) {
                    $isFree = false;
                    break;
                }
            }

            if ($isFree) {
                $assignedRobot = $robot;
                break;
            }
        }

        if (!$assignedRobot) {
            return back()->withErrors(['msg' => 'Geen geschikte robot is beschikbaar voor de volledige tijdsduur op dit moment.']);
        }

        for ($i = 0; $i < $duration; $i++) {
            ScheduleAllocation::create([
                'robot_id' => $assignedRobot->id,
                'vehicle_id' => $vehicle->id,
                'date' => $validated['date'],
                'slot' => $validated['start_slot'] + $i,
                'type' => ScheduleType::PRODUCTION,
            ]);
        }

        $vehicle->update(['status' => VehicleStatus::SCHEDULED]);

        return back()->with('success', "Voertuig ingepland bij robot: {$assignedRobot->name}");
    }
}
