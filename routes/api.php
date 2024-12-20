<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Api\Admission\MedicalCenterController;
use App\Http\Controllers\Api\GeneralSecurity\SpecialtyController;
use App\Http\Controllers\Api\MedicalConsultation\MedicalConsultationController;
use App\Http\Controllers\Api\MedicalConsultation\MedicalTurnController;
use App\Http\Controllers\Api\MedicalConsultation\TypeActivityController;
use App\Http\Controllers\CenterAttentionController;
use App\Http\Controllers\ConsultingController;
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

Route::middleware('auth:sanctum', 'api')->get('/user', function (Request $request) {
    return $request->user();
});

/*
Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/medical-center', [MedicalCenterController::class, 'getMedicalCenter']);
    Route::post('/specialty', [SpecialtyController::class, 'getSpecialty']);
    Route::post('/type-activity', [TypeActivityController::class, 'getTypeActivity']);

    Route::post('/medical-turn', [MedicalTurnController::class, 'getAvailableMedicalTurn']);

    Route::post('/create-medical-consultation', [MedicalConsultationController::class, 'create']);

});
*/

Route::get('/medical-center', [MedicalCenterController::class, 'getMedicalCenter']);
Route::post('/specialty', [SpecialtyController::class, 'getSpecialty']);
Route::post('/type-activity', [TypeActivityController::class, 'getTypeActivity']);

Route::post('/medical-turn', [MedicalTurnController::class, 'getAvailableMedicalTurn']);

Route::post('/create-medical-consultation', [MedicalConsultationController::class, 'create']);