<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\CampaignManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AnagraphicController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SupervisorScriptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/anagraphics', [AnagraphicController::class, 'adminIndex'])->name('admin.anagraphics.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::get('/campaigns/create', [CampaignManagementController::class, 'create'])->name('admin.campaigns.create');
    Route::post('/campaigns', [CampaignManagementController::class, 'store'])->name('admin.campaigns.store');
});
Route::apiResource('campaigns', CampaignController::class);
Route::middleware(['auth'])->apiResource('anagraphics', AnagraphicController::class);
Route::middleware(['auth'])->get('/anagraphics-caricamento', [AnagraphicController::class, 'create'])
    ->name('anagraphics.upload-form');

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('supervisor.categories.create');
    Route::get('/objections/upload', [SupervisorScriptController::class, 'createObjectionView'])->name('supervisor.objections.upload');
    Route::get('/scripts/create', [SupervisorScriptController::class, 'create'])->name('supervisor.scripts.create');
    Route::post('/scripts/create', [SupervisorScriptController::class, 'storeFromView'])->name('supervisor.scripts.view.store');
    Route::post('/scripts', [SupervisorScriptController::class, 'storeScript'])->name('supervisor.scripts.store');
    Route::post('/objections', [SupervisorScriptController::class, 'storeObjection'])->name('supervisor.objections.store');
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/subcategories', [CategoryController::class, 'storeSubcategory']);
    Route::get('/anagraphics/{anagraphic}/edit', [AnagraphicController::class, 'edit'])->name('supervisor.anagraphics.edit');
    Route::put('/anagraphics/{anagraphic}', [AnagraphicController::class, 'updateFromView'])->name('supervisor.anagraphics.update');
});