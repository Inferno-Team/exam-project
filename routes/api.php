<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\doctors\DoctorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\student\StudentController;
use App\Http\Controllers\SupervisorController;
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

    $route->post('/get_all_students/{year}', [StudentController::class, 'getAllStudent']);
    $route->get('/search', [StudentController::class, 'search']);
    $route->get('/search_by_id', [StudentController::class, 'searchUniv']);
    $route->get('/get_student_by_id/{id}', [StudentController::class, 'getStudentById']);
    $route->post('/add_student_mark1', [StudentController::class, 'addMark1']);
    $route->post('/add_student_mark2', [StudentController::class, 'addMark2']);
    $route->post('/add_student', [StudentController::class, 'addStudent']);
    $route->get('/get_student_year/{id}', [StudentController::class, 'getYear']);
    $route->get('/get_student_first_year/{id}', [StudentController::class, 'getFirstYear']);
    $route->get('/get_student_courses/{id}', [StudentController::class, 'getCourses']);
    $route->get('/get_student_year_marks/{id}/{year_id}', [StudentController::class, 'getYearMarks']);
    $route->get('/get_student_year_history/{id}/{year_id}', [StudentController::class, 'getYearHistory']);
    $route->get('/get_year_student_with_type/{yearId}/{type}', [StudentController::class, 'getYearStudentsType']);
    $route->post('/get_years', [YearController::class, 'get_years']);
    $route->post('/get_semesters/{year_id}', [YearController::class, 'get_semesters']);
    $route->get('/get_year/{id}', [YearController::class, 'getYear']);
    $route->post('/get_student_years/{id}', [StudentController::class, 'getStudentYear']);
    $route->post('/get_courses', [CourseController::class, 'getCourses']);
    $route->post('/get_doctors', [DoctorController::class, 'getDoctors']);
    $route->post('/get_supervisors', [DoctorController::class, 'getSupervisors']);
    $route->post('/get_supervisor/{id}', [DoctorController::class, 'getSupervisor']);
    $route->post('/get-doctor/{id}', [DoctorController::class, 'getDoctorById']);
    $route->post('/get_courses_by_selection', [CourseController::class, 'getCoursesBySelection']);
    $route->post('/add_course', [CourseController::class, 'addCourse']);
    $route->post('/add_course_to_student', [CourseController::class, 'addCourseToStudent']);
    $route->get('/get_sections', [SectionController::class, 'getSections']);
    $route->post('/add_supervisor', [SupervisorController::class, 'addSuper']);
    $route->get('/dates', [DateController::class, 'getDates']);
    $route->post('/set_dates', [DateController::class, 'setDates']);
    $route->post('/load-doctor-courses/{id}', [DoctorController::class, 'getDoctorCourses']);
    $route->post('/save_student_mark1', [StudentController::class, 'saveStudentMark1']);
    $route->post('/save_student_mark2', [StudentController::class, 'saveStudentMark2']);
    $route->get('/get_student_mark1/{id}', [StudentController::class, 'getStudentMark1']);
    $route->get('/get_students_year_count', [StudentController::class, 'getStudentsYearCount']);
    Route::post('/get_student_status/{id}', [CourseController::class, 'getStudentStatus']);
    Route::post('/get_students_status_by_year/{year_id}', [CourseController::class, 'getStudentStatusByYear']);
});
Route::post('/get_student_top_ten/{id}', [StudentController::class, 'getStudentsTopTen']);
