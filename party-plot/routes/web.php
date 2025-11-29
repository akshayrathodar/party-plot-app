<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\authAdmin;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Search
Route::get('/search', [PageController::class, 'search'])->name('search');

// Party Plots Routes (to be implemented)
Route::prefix('party-plots')->name('party-plots.')->group(function () {
    Route::get('/', [PageController::class, 'partyPlots'])->name('index');
    Route::get('/tag/{slug}', [PageController::class, 'partyPlotsByTag'])->name('tag');
    Route::get('/{slug}', [PageController::class, 'partyPlotDetails'])->name('show');
    Route::get('/create', [PageController::class, 'createPartyPlot'])->name('create');
});

// Admin Panel Routes
Route::prefix('admin')->group(function () {
    // Admin Login Routes (outside middleware)
    Route::get('/login', [AuthController::class, 'login'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'saveLogin'])->name('admin.saveLogin');

    // Admin Protected Routes
    Route::middleware([authAdmin::class])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        // Profile Routes
        Route::get('/profile/edit', [UserController::class, 'profile'])->name('admin.profile');
        Route::put('/profile/update', [UserController::class, 'profileSubmit'])->name('admin.profile.update');

        // Settings Routes
        Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
        Route::put('/settings/site', [SettingController::class, 'update'])->name('admin.settings.update');
        Route::post('/settings/theme', [SettingController::class, 'themeUpdate'])->name('admin.settings.themeupdate.post');
        Route::post('/settings/whatsapp', [SettingController::class, 'whatsappUpdate'])->name('admin.settings.whatsappUpdate.post');

        // Resource Routes
        Route::resource('roles', RoleController::class)->names([
            'index' => 'admin.roles.index',
            'create' => 'admin.roles.create',
            'store' => 'admin.roles.store',
            'show' => 'admin.roles.show',
            'edit' => 'admin.roles.edit',
            'update' => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy',
        ]);
        
        Route::resource('permissions', PermissionController::class)->names([
            'index' => 'admin.permissions.index',
            'create' => 'admin.permissions.create',
            'store' => 'admin.permissions.store',
            'show' => 'admin.permissions.show',
            'edit' => 'admin.permissions.edit',
            'update' => 'admin.permissions.update',
            'destroy' => 'admin.permissions.destroy',
        ]);

        Route::resource('users', UserController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        
        Route::get('/users/getUsersData', [UserController::class, 'getUsersData'])->name('admin.users.getUsersData');

        // Common Routes
        Route::get('/getDataById', [HomeController::class, 'getDataById'])->name('admin.getDataById');
        Route::get('/getDataByCondition', [HomeController::class, 'getDataByCondition'])->name('admin.getDataByCondition');
        Route::post('/media-delete', [HomeController::class, 'mediaDelete'])->name('admin.media-delete');
        Route::post('/updateStatus', [HomeController::class, 'updateStatus'])->name('admin.updateStatus');
    });
});

// Legacy route names for backward compatibility (redirect to admin routes)
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');
