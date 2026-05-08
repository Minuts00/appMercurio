<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AnagraphicController;
use App\Http\Controllers\CampaignController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/categories', [CategoryController::class, 'store']);
Route::post('/subcategories', [CategoryController::class, 'storeSubcategory']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
});
Route::apiResource('campaigns', CampaignController::class);
Route::middleware(['auth'])->apiResource('anagraphics', AnagraphicController::class);

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->group(function () {
    Route::post('/scripts', [SupervisorScriptController::class, 'storeScript'])->name('supervisor.scripts.store');
    Route::post('/objections', [SupervisorScriptController::class, 'storeObjection'])->name('supervisor.objections.store');
});