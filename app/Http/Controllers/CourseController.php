<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Section;
use App\Models\StudentCourses;
use App\Models\StudentYear;
use App\Models\Year;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourses(Request $request)
    {
        $year_id = $request->year_id;
        $section_id = $request->section_id;
        $courses = Course::where('section_id', $section_id)->where('year_id', $year_id)->get();
        return response()->json([
            'courses' => $courses,
            'year_id' => $year_id,
            'section_id' => $section_id,
        ], 200);
    }

    public function addCourse(Request $request)
    {
        $courseName =  $request->name;
        $year_id = $request->year_id;
        $type = $request->type;
        $section_id  = $request->section_id;
        $course = Course::create([
            'name' => $courseName,
            'section_id' => $section_id,
            'year_id' => $year_id,
            'type' => $type,
        ]);
        // insert this course for all student in out database
        // get all student for this year and below
       /*  $studentsCount = 0;
        for ($i = 1; $i <= $year_id; $i++) {
            // get students
            $sy = StudentYear::where('year_id', $i)->with('student')->get();

            foreach ($sy as $s) {
                $sc = StudentCourses::create([
                    'student_id' => $s->student->id,
                    'course_id' => $course->id,
                    'status' => 'اول مرة',
                ]);
                $studentsCount++;
            }
        } */
        return response()->json([
            'msg' => 'good',
        ], 200);
    }
}
