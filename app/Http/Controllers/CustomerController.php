<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.dashboard', [
            'vehicles' => $vehicles
        ]);
    }

    public function show(Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id()) {
            abort(403, 'Dit is niet jouw voertuig.');
        }

        return view('customer.show', [
            'vehicle' => $vehicle,
            'completionDate' => $vehicle->estimated_completion_date,
            'modules' => $vehicle->sorted_modules,
        ]);
    }
}
