<?php

namespace App\Models;

use App\Enums\ModuleCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Robot extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function allocations(): HasMany
    {
        return $this->hasMany(ScheduleAllocation::class);
    }

    public function canAssemble(Vehicle $vehicle): bool
    {
        $chassis = $vehicle->modules->where('category', \App\Enums\ModuleCategory::CHASSIS)->first();
        $drive = $vehicle->modules->where('category', \App\Enums\ModuleCategory::POWERTRAIN)->first();

        if (!$chassis || !$drive) return false;

        $type = $chassis->specifications['vehicle_type'] ?? '';
        $fuel = $drive->specifications['fuel_type'] ?? '';

        return match($this->name) {
            'Robot TwoWheels' => in_array($type, ['Step', 'Fiets', 'Scooter']),

            'Robot HydroBoy' => $fuel === 'Waterstof',

            'Robot HeavyD' => in_array($type, ['Vrachtwagen', 'Bus', 'Personenauto']),

            default => false,
        };
    }
}
