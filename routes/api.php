<?php

use App\Http\Controllers\Api\EmployeesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('employee', [EmployeesController::class, 'getAllEmployee']);
    Route::get('employee/first-join', [EmployeesController::class, 'getEmployeeFirstJoin']);
    Route::get('employee/history-off', [EmployeesController::class, 'gethistoryOffEmployees']);
    Route::get('employee/remaining-days-off', [EmployeesController::class, 'getRemainingDaysOff']);
    Route::delete('employee', [EmployeesController::class, 'destroy']);
    Route::put('employee', [EmployeesController::class, 'updateDataEmployee']);
});

// Rute login
Route::post('/login', [AuthController::class, 'login']);
// regis
Route::post('/register', [AuthController::class, 'register']);
