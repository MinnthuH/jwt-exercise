<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;

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

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);

Route::group(['middleware'=>['auth:api']],function() {

    // USER API ROUTES
    Route::get('/profile',[UserController::class,'profile']);
    Route::get('/logout',[UserController::class,'logout']);

    // COURSES API ROUTES
    Route::post('/course-enroll',[CourseController::class,'courseEnrollment']);
    Route::get('/total-courses',[CourseController::class,'totalCourses']);
    Route::get('/delete-courses/{$id}',[CourseController::class,'totaldeleteCourseCourses']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
