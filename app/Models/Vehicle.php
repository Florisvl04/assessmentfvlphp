<?php

namespace App\Models;

use App\Enums\VehicleStatus;
use App\Enums\ModuleCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vehicle extends Model
{
    protected $fillable = ['user_id', 'name', 'status'];

    protected function casts(): array
    {
        return [
            'status' => VehicleStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(Module::class);
    }

    public function getTotalPriceAttribute(): int
    {
        return $this->modules->sum('price');
    }

    public function getTotalRequiredTimeAttribute(): int
    {
        return $this->modules->sum('required_time');
    }

    public function getSortedModulesAttribute()
    {
        // Define the priority order
        $order = [
            ModuleCategory::CHASSIS->value => 1,
            ModuleCategory::POWERTRAIN->value => 2,
            ModuleCategory::WHEELS->value => 3,
            ModuleCategory::STEERING->value => 4,
            ModuleCategory::SEATS->value => 5,
        ];

        return $this->modules->sortBy(function ($module) use ($order) {
            return $order[$module->category->value] ?? 99;
        });
    }

    public function getEstimatedCompletionDateAttribute(): ?string
    {
        $lastAllocation = $this->hasMany(ScheduleAllocation::class)
            ->orderByDesc('date')
            ->orderByDesc('slot')
            ->first();

        if (!$lastAllocation) {
            return null; // Not scheduled yet
        }

        return $lastAllocation->date->format('d-m-Y') . " (Blok {$lastAllocation->slot})";
    }

    public function allocations()
    {
        return $this->hasMany(ScheduleAllocation::class);
    }
}
