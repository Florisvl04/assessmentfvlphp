<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->default('Mijn Voertuig');
            $table->string('status')->default('concept'); //
            $table->timestamps();
        });

        // 2. Pivot Table (Many-to-Many)
        Schema::create('module_vehicle', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('restrict');
            // 'restrict' prevents deleting a module if it is part of a sold car
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_vehicle');
        Schema::dropIfExists('vehicles');
    }
};
