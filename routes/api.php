<?php

use App\Http\Controllers\Api\AssessmentController;
use App\Http\Controllers\Api\AssessmentTestController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientSymptomController;
use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\Api\SymptomsIdentifiedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/test-notification',function(){
    $users = \App\Models\User::where(['email' => 'demonurse@yourfacility.com'])->get();
    /** @var \App\Models\PatientSymptom $patientSymptom */
    $patientSymptom = \App\Models\PatientSymptom::with(['patient','symptom','assistantNurse'])->latest()->first();
    \Illuminate\Support\Facades\Notification::sendNow($users,new \App\Notifications\SymptomReported($patientSymptom),[\NotificationChannels\Fcm\FcmChannel::class]);
    return 'sent!';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login',[AuthController::class,'login'])->name('auth.login');
Route::post('auth/forgot-password',[AuthController::class,'forgotPassword'])->name('auth.forgot-password');
Route::post('auth/reset-password',[AuthController::class,'resetPassword'])->name('auth.reset-password');
Route::post('auth/register',[AuthController::class,'register'])->name('auth.register');

Route::group(['middleware' => ['auth:sanctum','facility']],function(){

    Route::post('/me/update-mobile-token',[MeController::class,'updateMobileToken'])->name('me.update-mobile-token');

    Route::post('/me/update-profile',[MeController::class,'update'])->name('me.update-profile');
    Route::get('/me/stats',[MeController::class,'stats'])->name('me.stats');
    Route::get('/me/counter',[MeController::class,'counter'])->name('me.counter');
    Route::post('/me/update-counter',[MeController::class,'updateCounter'])->name('me.update-counter');

    Route::get('/facility',[FacilityController::class,'index'])->name('facility.index');
    Route::apiResource('categories', CategoryController::class);
    Route::post('patients/confirm',[PatientController::class,'confirm'])->name('patients.confirm');
    Route::apiResource('patients', PatientController::class);
    Route::apiResource('doctors', DoctorController::class);
    Route::post('assessments/{id}/email',[AssessmentController::class,'email'])->name('assessments.email');
    Route::apiResource('assessments', AssessmentController::class);
    Route::apiResource('assessment-tests', AssessmentTestController::class)->except(['update']);
    Route::post('assessment-tests/{id}/update',[AssessmentTestController::class,'update'])->name('assessment-tests.update');
    Route::apiResource('symptoms-identified', SymptomsIdentifiedController::class)->only(['index']);
    Route::get('/stats/symptoms',[StatsController::class,'symptoms'])->name('stats.symptoms');
    Route::post('notifications/mark-all-as-read',[NotificationController::class,'markAllAsRead'])->name('notification.mark-all-as-read');
    Route::apiResource('notifications', NotificationController::class)->only(['index','update']);

    Route::group(['middleware' => 'assistant_nurse'],function(){
        Route::apiResource('patient-symptoms', PatientSymptomController::class);
    });
});
