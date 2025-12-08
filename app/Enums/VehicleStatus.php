<?php

namespace App\Enums;

enum VehicleStatus: string
{
    case CONCEPT = 'concept';
    case PENDING = 'in_wachtrij';
    case SCHEDULED = 'ingepland';
    case IN_PRODUCTION = 'in_productie';
    case COMPLETED = 'gereed';
    case DELIVERED = 'geleverd';

    public function label(): string
    {
        return match($this) {
            self::CONCEPT => 'Concept',
            self::PENDING => 'In Wachtrij',
            self::SCHEDULED => 'Ingepland',
            self::IN_PRODUCTION => 'In Productie',
            self::COMPLETED => 'Gereed voor levering',
            self::DELIVERED => 'Geleverd',
        };
    }
}
