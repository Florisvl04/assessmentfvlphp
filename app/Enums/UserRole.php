<?php

namespace App\Enums;

enum UserRole: string
{
    case MECHANIC = 'monteur';
    case PLANNER = 'planner';
    case CUSTOMER = 'klant';
    case MANAGER = 'inkoper';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match($this) {
            self::MECHANIC => 'Monteur',
            self::PLANNER => 'Planner',
            self::CUSTOMER => 'Klant',
            self::MANAGER => 'Inkoper',
            self::ADMIN => 'admin',
        };
    }

}
