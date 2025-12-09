<?php

namespace App\Models;

use App\Enums\ScheduleType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'robot_id',
        'vehicle_id',
        'date',
        'slot',
        'type'
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'type' => ScheduleType::class,
        ];
    }

    public function robot(): BelongsTo
    {
        return $this->belongsTo(Robot::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
