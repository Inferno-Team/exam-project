<?php

namespace App\Http\Controllers;

use App\Jobs\InsertCourseStudentJob;
use App\Models\Course;
use App\Models\Section;
use App\Models\StudentCourses;
use App\Models\StudentYear;
use App\Models\Year;
use App\Models\YearSemester;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function getCourses(Request $request)
    {
        $year_id = $request->year_id;
        $section_id = $request->section_id;
        $courses = Course::where('section_id', $section_id)->whereHas('year_semester', fn ($ys) => $ys->where('year_id', $year_id)->with('year'))->with('year_semester.year')->get();
        // where('year_id', $year_id)->get();
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
        $semester_id = $request->semester_id;
        $section_id  = $request->section_id;
        $sy = YearSemester::where('year_id', $year_id)->where('semester_id', $semester_id)->first();
        if (!isset($sy)) {
            return response()->json([
                'code' => 404,
                'message' => "you can't add this course into with this selected year and semester."
            ], 404);
        }

        $course = Course::create([
            'name' => $courseName,
            'section_id' => $section_id,
            'sy_id' => $sy->id,
            'type' => $type,
        ]);
        $this->dispatch(new InsertCourseStudentJob($course, $year_id));

        // insert this course for all student in out database
        // get all student for this year and below

        return response()->json([
            'msg' => 'good',
            'course' => $course
        ], 200);
    }
}
