<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Module;
use App\Models\User;
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
        // Use short function to get value from enum
        $modules = Module::all()->groupBy(fn($m) => $m->category->value);

        $customers = User::where('role', UserRole::CUSTOMER)->orderBy('name')->get();

        return view('composer.create', [
            'customers'     => $customers,
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
            'customer_id' => 'nullable|exists:users,id',
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

        //Get owner ID, otherwise gets the logged in user
        $ownerId = $validated['customer_id'] ?? Auth::id();

        $vehicle = Vehicle::create([
            'user_id' => $ownerId,
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
        $user = Auth::user();

        $isOwner = $vehicle->user_id === $user->id;
        $isStaff = in_array($user->role, [UserRole::ADMIN, UserRole::MECHANIC, UserRole::PLANNER]);

        if (!$isOwner && !$isStaff) {
            abort(403, 'U heeft geen toegang tot dit voertuig.');
        }

        return view('customer.show', [
            'vehicle' => $vehicle,
            'modules' => $vehicle->sorted_modules,
            'totalPrice' => $vehicle->total_price
        ]);
    }
}
