<?php

use App\Http\Controllers\Api\StudentsController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\TodayWorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Students
Route::get('/students/{student:slug}', [StudentsController::class, 'show']);

// Work
Route::post('/work/scan/{student:slug}/{appointment}', [TodayWorkController::class, 'scan'])->name('work.scan');

// Subscription
Route::post('/students/subscribe/{student}', [SubscriptionController::class, 'subscribe']);
