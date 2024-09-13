<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssessmentController;
use App\Http\Controllers\Admin\AssessmentTestController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CriteriaController;
use App\Http\Controllers\Admin\DiseaseController;
use App\Http\Controllers\Admin\DiseaseTestController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\GroupController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\NurseController;
use App\Http\Controllers\Admin\ResidentController;
use App\Http\Controllers\Admin\SymptomController;
use App\Http\Requests\GuestEmailVerificationRequest;
use Illuminate\Support\Facades\Route;

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
Route::get('/email/verify/{id}/{hash}', function (GuestEmailVerificationRequest $request) {
    $request->fulfill();
    return view('auth-confirm-mail');
})->middleware(['signed'])->name('verification.verify');

Route::group(['middleware' => 'guest','as' => 'auth.'],function(){
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'doLogin'])->name('do-login');
});

Route::group(['middleware' => 'auth'],function(){
    Route::get('/',[HomeController::class,'index'])->name('home');

    Route::group(['middleware' => 'haist_admin'],function(){
        Route::resource('categories', CategoryController::class);
        Route::resource('symptoms', SymptomController::class);
        Route::resource('admins', AdminController::class);
        Route::resource('facilities', FacilityController::class);
        Route::resource('diseases', DiseaseController::class);
        Route::resource('criteria', CriteriaController::class);
        Route::resource('tests', DiseaseTestController::class);
    });

    Route::group(['middleware' => 'admin'],function(){
        Route::get('compare-facilities',[HomeController::class,'compareFacilities'])->name('home.compare-facilities');
        Route::resource('groups', GroupController::class)->only(['store']);
        Route::resource('managers', ManagerController::class);
        Route::resource('nurses', NurseController::class);
    });

    Route::group(['middleware' => 'manager'],function(){
        Route::resource('doctors', DoctorController::class);
        Route::get('assessments/{id}/possible-diseases',[AssessmentController::class,'possibleDiseases'])->name('assessment.possible-diseases');
        Route::resource('assessments', AssessmentController::class);
        Route::resource('residents', ResidentController::class);
        Route::resource('assessment-tests', AssessmentTestController::class);
    });

    Route::get('/logout',[AuthController::class,'logout'])->name('auth.logout');
});
