<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
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
