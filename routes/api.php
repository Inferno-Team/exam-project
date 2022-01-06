<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\student\StudentController;
use App\Http\Controllers\YearController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/submit', [LoginController::class, 'logIn']);

Route::group(["middleware" => ["auth:sanctum"]], function ($route) {
    $route->post('/logout', [LoginController::class, 'logout']);
    $route->post('/get_all_students', [StudentController::class, 'getAllStudent']);
    $route->post('/add_student', [StudentController::class, 'addStudent']);
    $route->post('/get_years', [YearController::class, 'get_years']);
    $route->post('/get_courses', [CourseController::class, 'getCourses']);
    $route->post('/add_course', [CourseController::class, 'addCourse']);
    $route->get('/get_sections', [SectionController::class, 'getSections']);
});
