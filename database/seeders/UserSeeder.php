<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Monteur',
            'email' => 'monteur@futurefactory.nl',
            'role' => UserRole::MECHANIC,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Planner',
            'email' => 'planner@futurefactory.nl',
            'role' => UserRole::PLANNER,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Inkoper',
            'email' => 'inkoper@futurefactory.nl',
            'role' => UserRole::MANAGER,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Klant',
            'email' => 'klant@gmail.com',
            'role' => UserRole::CUSTOMER,
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@futurefactory.nl',
            'role' => UserRole::ADMIN,
            'password' => Hash::make('password'),
        ]);
    }
}
