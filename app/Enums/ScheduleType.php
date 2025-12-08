<?php

namespace App\Enums;

enum ScheduleType: string
{
    case PRODUCTION = 'productie';
    case MAINTENANCE = 'onderhoud';

    public function color(): string
    {
        return match($this) {
            self::PRODUCTION => 'bg-green-100 text-green-800',
            self::MAINTENANCE => 'bg-red-100 text-red-800',
        };
    }
}
