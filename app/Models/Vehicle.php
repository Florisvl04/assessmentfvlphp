<?php

namespace App\Models;

use App\Enums\ScheduleType;
use App\Enums\VehicleStatus;
use App\Enums\ModuleCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Vehicle extends Model
{
    use HasFactory;
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

    public function allocations(): HasMany
    {
        return $this->hasMany(ScheduleAllocation::class);
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
        $lastAllocation = $this->allocations
            ->sortByDesc(function ($alloc) {
                return $alloc->date->format('Ymd') . $alloc->slot;
            })
            ->first();

        if (!$lastAllocation) {
            return null;
        }

        return $lastAllocation->date->format('d-m-Y') . " (Blok {$lastAllocation->slot})";
    }

    /**
     * Helper: Check if fully scheduled (Green Progress Bar)
     */
    public function getIsFullyPlannedAttribute(): bool
    {
        $scheduledCount = $this->allocations
            ->where('type', ScheduleType::PRODUCTION)
            ->count();

        return $scheduledCount >= $this->total_required_time;
    }

    public function getIsCompletedAttribute(): bool
    {

        $allocations = $this->allocations->where('type', ScheduleType::PRODUCTION);

        if ($allocations->isEmpty()) {
            return false;
        }

        $lastAllocation = $allocations->sortByDesc(function ($alloc) {
            return $alloc->date->format('Ymd') . $alloc->slot;
        })->first();

        $timeString = match($lastAllocation->slot) {
            1 => '10:00:00',
            2 => '12:00:00',
            3 => '14:00:00',
            4 => '16:00:00',
            default => '17:00:00',
        };

        $completionMoment = $lastAllocation->date->copy()->setTimeFromTimeString($timeString);

        return Carbon::now()->greaterThan($completionMoment);
    }

    /**
     * Helper: Progress Percent (0-100) for the Progress Bar
     */
    public function getProgressPercentAttribute(): int
    {
        if ($this->total_required_time <= 0) return 0;

        $planned = $this->allocations
            ->where('type', ScheduleType::PRODUCTION)
            ->count();

        $percent = ($planned / $this->total_required_time) * 100;

        return min(100, round($percent));
    }

    /**
     * Helper: Progress Text (e.g. "3 / 4 blokken")
     */
    public function getProgressTextAttribute(): string
    {
        $planned = $this->allocations
            ->where('type', ScheduleType::PRODUCTION)
            ->count();

        return "{$planned} / {$this->total_required_time} blokken";
    }
}
