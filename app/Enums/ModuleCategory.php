<?php

namespace App\Enums;

enum ModuleCategory: string
{
    case CHASSIS = 'chassis';
    case POWERTRAIN = 'aandrijving';
    case WHEELS = 'wielen';
    case STEERING = 'stuur';
    case SEATS = 'stoelen';

    public function label(): string
    {
        return match($this) {
            self::CHASSIS => 'Chassis',
            self::POWERTRAIN => 'Aandrijving',
            self::WHEELS => 'Wielen',
            self::STEERING => 'Stuur',
            self::SEATS => 'Stoelen / Zadel',
        };
    }
}
