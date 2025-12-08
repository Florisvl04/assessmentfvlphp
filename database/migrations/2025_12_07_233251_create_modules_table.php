<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();

            // Properties that are consistent through all modules
            $table->string('name')->unique();
            $table->string('category');
            $table->integer('price');
            $table->integer('required_time');
            $table->string('image_path')->nullable();

            // Flexible properties (Specifics like 'dimensions', 'horsepower', 'color')
            $table->json('specifications')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
