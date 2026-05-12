<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\CampaignManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AnagraphicController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\SupervisorScriptController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['is_active'] = true;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Le credenziali fornite non sono corrette.',
        ])->onlyInput('email');
    })->name('login.attempt');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->middleware('auth')->name('logout');

    Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/anagraphics', [AnagraphicController::class, 'adminIndex'])->name('admin.anagraphics.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::patch('/users/{user}/disable', [UserManagementController::class, 'disable'])->name('admin.users.disable');
    Route::get('/campaigns/create', [CampaignManagementController::class, 'create'])->name('admin.campaigns.create');
    Route::post('/campaigns', [CampaignManagementController::class, 'store'])->name('admin.campaigns.store');
});
Route::apiResource('campaigns', CampaignController::class);
Route::middleware(['auth'])->apiResource('anagraphics', AnagraphicController::class);
Route::middleware(['auth'])->get('/anagraphics-caricamento', [AnagraphicController::class, 'create'])
    ->name('anagraphics.upload-form');

Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->group(function () {
    Route::get('/anagraphics', [AnagraphicController::class, 'supervisorEdit'])->name('supervisors.anagraphics.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('supervisor.categories.create');
    Route::get('/objections/upload', [SupervisorScriptController::class, 'createObjectionView'])->name('supervisor.objections.upload');
    Route::get('/scripts/create', [SupervisorScriptController::class, 'create'])->name('supervisor.scripts.create');
    Route::post('/scripts/create', [SupervisorScriptController::class, 'storeFromView'])->name('supervisor.scripts.view.store');
    Route::post('/scripts', [SupervisorScriptController::class, 'storeScript'])->name('supervisor.scripts.store');
    Route::post('/objections', [SupervisorScriptController::class, 'storeObjection'])->name('supervisor.objections.store');
    Route::post('/categories', [CategoryController::class, 'store'])->name('supervisors.categories.store');
    Route::post('/subcategories', [CategoryController::class, 'storeSubcategory'])->name('supervisors.subcategories.store');
    Route::get('/anagraphics/{anagraphic}/edit', [AnagraphicController::class, 'edit'])->name('supervisors.anagraphics.edit');
    Route::put('/anagraphics/{anagraphic}', [AnagraphicController::class, 'updateFromView'])->name('supervisors.anagraphics.update');
});
