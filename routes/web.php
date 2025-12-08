<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleComposerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:monteur'])->group(function () {
    Route::get('/builder', [VehicleComposerController::class, 'create'])->name('composer.create');
    Route::post('/builder', [VehicleComposerController::class, 'store'])->name('composer.store');
    Route::get('/vehicle/{vehicle}', [VehicleComposerController::class, 'show'])->name('composer.show');
});

Route::middleware(['auth', 'role:planner'])->group(function () {
    Route::get('/planning', [PlannerController::class, 'index'])->name('planning.index');
    Route::post('/planning/maintenance', [PlannerController::class, 'storeMaintenance'])->name('planning.maintenance');
    Route::post('/planning/schedule', [PlannerController::class, 'storeProduction'])->name('planning.schedule');
});

Route::middleware(['auth', 'role:klant'])->group(function () {
    Route::get('/my-vehicles', [CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/my-vehicles/{vehicle}', [CustomerController::class, 'show'])->name('customer.show');
});

Route::middleware(['auth', 'role:inkoper'])->group(function () {
    Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/create', [ModuleController::class, 'create'])->name('modules.create');
    Route::post('/modules', [ModuleController::class, 'store'])->name('modules.store');
    Route::get('/modules/{module}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
    Route::put('/modules/{module}', [ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{module}', [ModuleController::class, 'destroy'])->name('modules.destroy');
});

require __DIR__.'/auth.php';
