<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\DiagnoseController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/patient', [PatientController::class, 'addPatient'])->name('addPatient');
Route::post('/service', [ServiceController::class, 'addService'])->name('addService');
Route::post('/diagnose', [DiagnoseController::class, 'addDiagnose'])->name('addSDiagnose');
Route::prefix('appointment')->group(function() {
    Route::post('/', [AppointmentController::class, 'addAppointment'])->name('addAppointment');
    Route::get('/{id}', [AppointmentController::class, 'getDetailAppointment'])->name('getDetailAppointment');
    Route::patch('/{id}', [AppointmentController::class, 'editAppointment'])->name('editAppointment');
});

Route::fallback(function() {
    return response()->json([
        'success' => false,
        'message' => 'Route not found',
        'statusCode' => 404,
    ], 404);
});
