<?php

use App\Http\Controllers\FloSettingsController;
use App\Http\Controllers\SnapScanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/settings', [FloSettingsController::class, 'Index'])
        ->name('settings');

});

Route::post('/snapscan/test', [SnapScanController::class, 'Payment'])
    ->name('payment.notification');

Route::post('/snapscan/webhook', [SnapScanController::class, 'WebHook'])
    ->name('snapscan.webhook');


Route::get('/snapscan', [SnapScanController::class, 'Index'])
    ->name('snapscan.payment');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('/settings/update', [FloSettingsController::class, 'Update'])
        ->name('settings.update');
});




/*Route::get('/snapscan', function () {
    return Inertia::render('SnapScan', [
        'price' => 50,
    ]);
})->name('snapscan.payment');*/

/*Route::get('/snapscan', function () {
    return Inertia::render('SnapScan', [
    ]);
})->name('snapscan.payment');*/
