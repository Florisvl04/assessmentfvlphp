<?php

use App\Models\Robot;
use App\Models\Vehicle;
use App\Models\Module;
use App\Enums\ModuleCategory;
use Illuminate\Database\Eloquent\Collection;

// Test 1: Robot TwoWheels can assemble a 'Fiets'
it('allows Robot TwoWheels to assemble a Fiets', function () {
    $robot = new Robot(['name' => 'Robot TwoWheels']);

    $chassis = new Module([
        'category' => ModuleCategory::CHASSIS,
        'specifications' => ['vehicle_type' => 'Fiets']
    ]);

    $powertrain = new Module([
        'category' => ModuleCategory::POWERTRAIN,
        'specifications' => ['fuel_type' => 'Spierkracht']
    ]);

    $vehicle = new Vehicle();
    $vehicle->setRelation('modules', new Collection([$chassis, $powertrain]));

    expect($robot->canAssemble($vehicle))->toBeTrue();
});

// Test 2: Robot TwoWheels CANNOT assemble a 'Vrachtwagen'
it('denies Robot TwoWheels from assembling a Vrachtwagen', function () {
    $robot = new Robot(['name' => 'Robot TwoWheels']);

    $chassis = new Module([
        'category' => ModuleCategory::CHASSIS,
        'specifications' => ['vehicle_type' => 'Vrachtwagen']
    ]);

    $powertrain = new Module([
        'category' => ModuleCategory::POWERTRAIN,
        'specifications' => ['fuel_type' => 'Diesel']
    ]);

    $vehicle = new Vehicle();
    $vehicle->setRelation('modules', new Collection([$chassis, $powertrain]));

    expect($robot->canAssemble($vehicle))->toBeFalse();
});

// Test 3: Robot HydroBoy only cares about Hydrogen
it('allows Robot HydroBoy to assemble any Waterstof vehicle', function () {
    $robot = new Robot(['name' => 'Robot HydroBoy']);

    $chassis = new Module([
        'category' => ModuleCategory::CHASSIS,
        'specifications' => ['vehicle_type' => 'Vrachtwagen']
    ]);

    $powertrain = new Module([
        'category' => ModuleCategory::POWERTRAIN,
        'specifications' => ['fuel_type' => 'Waterstof']
    ]);

    $vehicle = new Vehicle();
    $vehicle->setRelation('modules', new Collection([$chassis, $powertrain]));

    expect($robot->canAssemble($vehicle))->toBeTrue();
});
