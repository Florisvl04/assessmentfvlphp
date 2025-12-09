<?php

use App\Models\Vehicle;
use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

it('calculates the total price by summing up modules', function () {
    // 1. Create a "Blank" Vehicle
    $vehicle = new Vehicle();

    // 2. Create fake modules

    $module1 = new Module(['price' => 100]);
    $module2 = new Module(['price' => 250]);
    $module3 = new Module(['price' => 50]);

    $vehicle->setRelation('modules', new Collection([
        $module1,
        $module2,
        $module3
    ]));

    // 3. Check price
    // 100 + 250 + 50 = 400
    expect($vehicle->total_price)->toBe(400);
});
