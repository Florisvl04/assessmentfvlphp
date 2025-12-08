<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Vehicle;
use App\Enums\ModuleCategory;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VehicleComposerController extends Controller
{
    public function create()
    {
        $modules = Module::all()->groupBy(fn($m) => $m->category->value);

        return view('composer.create', [
            'chassisList'   => $modules[ModuleCategory::CHASSIS->value] ?? [],
            'driveList'     => $modules[ModuleCategory::POWERTRAIN->value] ?? [],
            'wheelsList'    => $modules[ModuleCategory::WHEELS->value] ?? [],
            'steeringList'  => $modules[ModuleCategory::STEERING->value] ?? [],
            'seatsList'     => $modules[ModuleCategory::SEATS->value] ?? [],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'chassis_id'  => 'required|exists:modules,id',
            'drive_id'    => 'required|exists:modules,id',
            'wheels_id'   => 'required|exists:modules,id',
            'steering_id' => 'required|exists:modules,id',
            'seats_id'    => 'nullable|exists:modules,id',
        ]);

        $chassis = Module::findOrFail($validated['chassis_id']);
        $wheels  = Module::findOrFail($validated['wheels_id']);

        $compatibleChassis = $wheels->specifications['compatible_chassis'] ?? [];

        if (!in_array($chassis->name, $compatibleChassis)) {
            throw ValidationException::withMessages([
                'wheels_id' => "De gekozen wielen ({$wheels->name}) passen niet op het chassis ({$chassis->name}).",
            ]);
        }

        $vehicle = Vehicle::create([
            'user_id' => Auth::id(),
            'name'    => $validated['name'],
            'status'  => VehicleStatus::CONCEPT,
        ]);

        $moduleIds = array_filter([
            $validated['chassis_id'],
            $validated['drive_id'],
            $validated['wheels_id'],
            $validated['steering_id'],
            $validated['seats_id'] ?? null,
        ]);

        $vehicle->modules()->attach($moduleIds);

        return redirect()->route('composer.show', $vehicle);
    }

    public function show(Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id() && Auth::user()->role !== \App\Enums\UserRole::ADMIN) {
            abort(403);
        }

        return view('composer.show', [
            'vehicle' => $vehicle,
            'modules' => $vehicle->sorted_modules,
            'totalPrice' => $vehicle->total_price
        ]);
    }
}
