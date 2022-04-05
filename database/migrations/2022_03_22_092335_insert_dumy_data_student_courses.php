<?php

use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourses;
use App\Models\StudentYear;
use App\Models\Year;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDumyDataStudentCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $courses  = Course::get();
        foreach ($courses as $course) {
            $year_id = $course->year_id;
            for ($i = 5; $i >= $year_id; $i--) {
                $sys = StudentYear::where('year_id', $i)->with('student')->get();
                foreach ($sys as $sy) {
                    $student = $sy->student;
                    $sc = StudentCourses::insert([
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'status' => 'اول مرة'
                    ]);
                }
            }
        }
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
