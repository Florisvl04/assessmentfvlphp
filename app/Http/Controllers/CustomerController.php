<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === UserRole::CUSTOMER) {
            $vehicles = Vehicle::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $vehicles = Vehicle::orderBy('created_at', 'desc')->get();
        }

        return view('customer.dashboard', [
            'vehicles' => $vehicles
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        $user = Auth::user();

        if ($vehicle->user_id !== $user->id && $user->role === UserRole::CUSTOMER) {
            abort(403, 'Dit is niet jouw voertuig.');
        }

        return view('customer.show', [
            'vehicle' => $vehicle,
            'completionDate' => $vehicle->estimated_completion_date,
            'modules' => $vehicle->sorted_modules,
        ]);
    }
}
