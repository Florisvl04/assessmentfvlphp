<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Enums\ModuleCategory;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. CHASSIS (The Foundation)
        // ==========================================

        // For: Step
        Module::create([
            'name' => 'Chassis StepLite',
            'category' => ModuleCategory::CHASSIS,
            'price' => 150,
            'required_time' => 1,
            'image_path' => 'chassis_step.jpg',
            'specifications' => [
                'wheel_count' => 2,
                'vehicle_type' => 'Step',
                'dimensions' => ['l' => 80, 'b' => 15, 'h' => 10],
            ],
        ]);

        // For: Fiets
        Module::create([
            'name' => 'Chassis CityBike Frame',
            'category' => ModuleCategory::CHASSIS,
            'price' => 300,
            'required_time' => 1,
            'image_path' => 'chassis_bike.jpg',
            'specifications' => [
                'wheel_count' => 2,
                'vehicle_type' => 'Fiets',
                'dimensions' => ['l' => 180, 'b' => 50, 'h' => 100],
            ],
        ]);

        // For: Scooter
        Module::create([
            'name' => 'Chassis VespaClone',
            'category' => ModuleCategory::CHASSIS,
            'price' => 800,
            'required_time' => 2,
            'image_path' => 'chassis_scooter.jpg',
            'specifications' => [
                'wheel_count' => 2,
                'vehicle_type' => 'Scooter',
                'dimensions' => ['l' => 190, 'b' => 70, 'h' => 110],
            ],
        ]);

        // For: Personenauto
        Module::create([
            'name' => 'Chassis Nikinella',
            'category' => ModuleCategory::CHASSIS,
            'price' => 4400,
            'required_time' => 3, // 6 hours
            'image_path' => 'chassis_car.jpg',
            'specifications' => [
                'wheel_count' => 4,
                'vehicle_type' => 'Personenauto',
                'dimensions' => ['l' => 400, 'b' => 186, 'h' => 165],
            ],
        ]);

        // For: Vrachtwagen (Needs heavy robot!)
        Module::create([
            'name' => 'Chassis HeavyHauler',
            'category' => ModuleCategory::CHASSIS,
            'price' => 12000,
            'required_time' => 4, // 8 hours (Full day)
            'image_path' => 'chassis_truck.jpg',
            'specifications' => [
                'wheel_count' => 8,
                'vehicle_type' => 'Vrachtwagen',
                'dimensions' => ['l' => 800, 'b' => 250, 'h' => 300],
            ],
        ]);

        // For: Bus
        Module::create([
            'name' => 'Chassis CityBus Long',
            'category' => ModuleCategory::CHASSIS,
            'price' => 15000,
            'required_time' => 4,
            'image_path' => 'chassis_bus.jpg',
            'specifications' => [
                'wheel_count' => 6,
                'vehicle_type' => 'Bus',
                'dimensions' => ['l' => 1200, 'b' => 255, 'h' => 320],
            ],
        ]);

        // ==========================================
        // 2. AANDRIJVING (Engines)
        // ==========================================

        // Electric (Light - for Step/Bike)
        Module::create([
            'name' => 'ElectroMotor Mini 250W',
            'category' => ModuleCategory::POWERTRAIN,
            'price' => 100,
            'required_time' => 1,
            'image_path' => 'engine_electric_small.jpg',
            'specifications' => [
                'fuel_type' => 'Elektriciteit',
                'horsepower' => 0.5,
            ],
        ]);

        // Electric (Medium - for Scooter)
        Module::create([
            'name' => 'ElectroMotor City 2kW',
            'category' => ModuleCategory::POWERTRAIN,
            'price' => 500,
            'required_time' => 1,
            'image_path' => 'engine_scooter.jpg',
            'specifications' => [
                'fuel_type' => 'Elektriciteit',
                'horsepower' => 3,
            ],
        ]);

        // Hydrogen (Car)
        Module::create([
            'name' => 'Waterstof Cell 138',
            'category' => ModuleCategory::POWERTRAIN,
            'price' => 32000,
            'required_time' => 2,
            'image_path' => 'engine_hydrogen.jpg',
            'specifications' => [
                'fuel_type' => 'Waterstof',
                'horsepower' => 138,
            ],
        ]);

        // Electric (Car)
        Module::create([
            'name' => 'TeslaPOWERTRAIN 400',
            'category' => ModuleCategory::POWERTRAIN,
            'price' => 18000,
            'required_time' => 2,
            'image_path' => 'engine_tesla.jpg',
            'specifications' => [
                'fuel_type' => 'Elektriciteit',
                'horsepower' => 400,
            ],
        ]);

        // Hydrogen (Heavy Duty - Truck/Bus)
        Module::create([
            'name' => 'HydroHeavy V8 Equivalent',
            'category' => ModuleCategory::POWERTRAIN,
            'price' => 55000,
            'required_time' => 3,
            'image_path' => 'engine_truck_h2.jpg',
            'specifications' => [
                'fuel_type' => 'Waterstof',
                'horsepower' => 600,
            ],
        ]);

        // ==========================================
        // 3. WIELEN (Wheels - Check Compatibility!)
        // ==========================================

        // Small Wheels (Step/Scooter)
        Module::create([
            'name' => 'Wieltjes 8 inch (2x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 50,
            'required_time' => 1,
            'image_path' => 'wheels_small.jpg',
            'specifications' => [
                'tire_type' => 'Hard Rubber',
                'diameter' => 8,
                'count' => 2,
                'compatible_chassis' => ['Chassis StepLite'],
            ],
        ]);

        // Bike Wheels
        Module::create([
            'name' => 'Fietswielen 28 inch (2x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 120,
            'required_time' => 1,
            'image_path' => 'wheels_bike.jpg',
            'specifications' => [
                'tire_type' => 'Allseason',
                'diameter' => 28,
                'count' => 2,
                'compatible_chassis' => ['Chassis CityBike Frame'],
            ],
        ]);

        // Scooter Wheels
        Module::create([
            'name' => 'Scooterbanden Sport (2x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 200,
            'required_time' => 1,
            'image_path' => 'wheels_scooter.jpg',
            'specifications' => [
                'tire_type' => 'Zomer',
                'diameter' => 12,
                'count' => 2,
                'compatible_chassis' => ['Chassis VespaClone'],
            ],
        ]);

        // Car Wheels (Summer)
        Module::create([
            'name' => 'Autobanden Z15 (4x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 1200,
            'required_time' => 1,
            'image_path' => 'wheels_car_summer.jpg',
            'specifications' => [
                'tire_type' => 'Zomer',
                'diameter' => 15,
                'count' => 4,
                'compatible_chassis' => ['Chassis Nikinella'],
            ],
        ]);

        // Car Wheels (Winter)
        Module::create([
            'name' => 'Autobanden SnowGrip (4x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 1400,
            'required_time' => 1,
            'image_path' => 'wheels_car_winter.jpg',
            'specifications' => [
                'tire_type' => 'Winter',
                'diameter' => 16,
                'count' => 4,
                'compatible_chassis' => ['Chassis Nikinella'],
            ],
        ]);

        // Truck Wheels
        Module::create([
            'name' => 'Truck HeavyLoad (8x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 8000,
            'required_time' => 2,
            'image_path' => 'wheels_truck.jpg',
            'specifications' => [
                'tire_type' => 'Allseason',
                'diameter' => 22,
                'count' => 8,
                'compatible_chassis' => ['Chassis HeavyHauler'],
            ],
        ]);

        // Bus Wheels
        Module::create([
            'name' => 'Bus CitySlickers (6x)',
            'category' => ModuleCategory::WHEELS,
            'price' => 6000,
            'required_time' => 2,
            'image_path' => 'wheels_bus.jpg',
            'specifications' => [
                'tire_type' => 'Allseason',
                'diameter' => 22,
                'count' => 6,
                'compatible_chassis' => ['Chassis CityBus Long'],
            ],
        ]);

        // ==========================================
        // 4. STUUR (Steering)
        // ==========================================

        Module::create([
            'name' => 'Stuur Schapenstadium',
            'category' => ModuleCategory::STEERING,
            'price' => 400,
            'required_time' => 1,
            'image_path' => 'steering_sheep.jpg',
            'specifications' => [
                'shape' => 'Stadium',
                'modifications' => 'Schapenvacht',
            ],
        ]);

        Module::create([
            'name' => 'Stuur Classic Round',
            'category' => ModuleCategory::STEERING,
            'price' => 150,
            'required_time' => 1,
            'image_path' => 'steering_classic.jpg',
            'specifications' => [
                'shape' => 'Rond',
                'modifications' => 'Geen',
            ],
        ]);

        Module::create([
            'name' => 'Fietsstuur Sport',
            'category' => ModuleCategory::STEERING,
            'price' => 50,
            'required_time' => 1,
            'image_path' => 'steering_bike.jpg',
            'specifications' => [
                'shape' => 'Recht',
                'modifications' => 'Handvatverwarming',
            ],
        ]);

        Module::create([
            'name' => 'Truck Hexagon Wheel',
            'category' => ModuleCategory::STEERING,
            'price' => 900,
            'required_time' => 1,
            'image_path' => 'steering_truck.jpg',
            'specifications' => [
                'shape' => 'Hexagon',
                'modifications' => 'Hydraulisch',
            ],
        ]);

        // ==========================================
        // 5. STOELEN (Seats)
        // ==========================================

        Module::create([
            'name' => 'Leren Autostoelen (5 stuks)',
            'category' => ModuleCategory::SEATS,
            'price' => 1600,
            'required_time' => 1,
            'image_path' => 'seats_leather.jpg',
            'specifications' => [
                'count' => 5,
                'material' => 'Leer',
            ],
        ]);

        Module::create([
            'name' => 'Fietszadel Gel',
            'category' => ModuleCategory::SEATS,
            'price' => 45,
            'required_time' => 1,
            'image_path' => 'seats_bike.jpg',
            'specifications' => [
                'count' => 1,
                'material' => 'Gel/Kunststof',
            ],
        ]);

        Module::create([
            'name' => 'Bus Banken (40 stuks)',
            'category' => ModuleCategory::SEATS,
            'price' => 5000,
            'required_time' => 2,
            'image_path' => 'seats_bus.jpg',
            'specifications' => [
                'count' => 40,
                'material' => 'Stof (Vandaalbestendig)',
            ],
        ]);
    }
}
