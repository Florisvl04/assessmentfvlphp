<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('robots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('schedule_allocations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('robot_id')->constrained();

            // Nullable because Maintenance doesn't need a vehicle
            $table->foreignId('vehicle_id')->nullable()->constrained();

            $table->date('date');
            $table->tinyInteger('slot');

            $table->string('type');

            $table->timestamps();

            // A robot cannot do two things at the same date and slot.
            // This Unique constraint prevents double-booking at the DB level.
            $table->unique(['robot_id', 'date', 'slot']);
        });
    }
};
