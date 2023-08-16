<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    Auth\LoginController,
    Auth\LogoutController,
    StudentsController,
    GradesController,
    ScannerController,
    AppointmentsController,
    TodayWorkController,
    SubscriptionController
};

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

// Auth
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'authenticate')->name('authenticate');
})->middleware('guest');

Route::post('/logout', LogoutController::class)
    ->middleware('auth')
    ->name('logout');

// Dashboard
Route::get('/', DashboardController::class)
    ->middleware('auth')
    ->name('dashboard');

// Scanner
Route::get('/scanner', ScannerController::class)
    ->middleware('auth')
    ->name('scanner');

// Students
Route::resource('/students', StudentsController::class)
    ->middleware('auth');
// Subscription
Route::post('/students/subscribe/{student}', [SubscriptionController::class, 'subscribe'])
    ->middleware('auth')
    ->name('students.subscribe');

// Grades
Route::resource('/grades', GradesController::class)
    ->middleware('auth');

// Appointments
Route::resource('/appointments', AppointmentsController::class)
    ->middleware('auth');
Route::controller(TodayWorkController::class)->middleware('auth')->group(function () {
    Route::get('/work', 'index')
        ->name('work');
    Route::get('/work/start/{appointment}', 'start')->name('work.start');
});
