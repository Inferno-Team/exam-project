<?php

namespace App\Http\Controllers;

use App\Jobs\InsertCourseStudentJob;
use App\Models\Course;
use App\Models\Section;
use App\Models\Student;
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
        $semester_id = $request->semester_id;
        $type = $request->type;
        $section_id  = $request->section_id;
        $sy = YearSemester::find($request->semester_id);
        
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
        if ($course->type == 'عادي')
            $this->dispatch(new InsertCourseStudentJob($course, $year_id));
        else {

            info($request->selection_type);
            $course->selection_type = $request->selection_type;
            $course->save();
        }
        // insert this course for all student in out database
        // get all student for this year and below

        return response()->json([
            'msg' => 'good',
            'course' => $course
        ], 200);
    }
    public function getCoursesBySelection(Request $request)
    {
        $courses = Course::where('selection_type', 'like', $request->selection)->get();

        return response()->json($courses, 200);
    }
    public function addCourseToStudent(Request $request)
    {
        // request [ univ_id , course_id , selection_name , selection_size ]
        $student = Student::where('univ_id', $request->univ_id)->first();
        if (!isset($student)) {
            return response()->json([
                'code' => 404,
                'msg' => 'الطلاب غير موجود',
            ], 200);
        }
        $studentCourses = StudentCourses::where('student_id', $student->id)
            ->whereHas(
                'course',
                fn ($course) => $course->where('selection_type', $request->selection_name)
            )->with('course')->get();
           info(count($studentCourses) . '   ' . $request->selection_size);
        if (count($studentCourses) >= $request->selection_size) {
            return response()->json([
                'code' => 400,
                'msg' => "لقد تم بالفعل اختيار كافة المواد لهذة المجموعة",
                'course' => $studentCourses
            ], 200);
        }
        $studentCourses = StudentCourses::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'status' => 'اول مرة'
        ]);
        return response()->json([
            'code' => 200,
            'msg' => "تم اختيار مادة من " . $request->selection_name . " لهذا الطالب ",
            'course' => $studentCourses
        ], 200);
    }
}
