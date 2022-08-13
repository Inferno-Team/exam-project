<?php

namespace App\Http\Controllers;

use App\Jobs\InsertCourseStudentJob;
use App\Models\Course;
use App\Models\Dates;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentCourses;
use App\Models\StudentStatus;
use App\Models\StudentYear;
use App\Models\Year;
use App\Models\YearSemester;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function getCourses(Request $request)
    {
        $year_id = $request->year_id;
        $section_id = $request->section_id;
        $date = Dates::first();
        $current = '';
        $semester = '%';
        if (isset($date)) {
            $current = $date->current;
        }
        if ($current == 'first-tirm') {
            $semester = 'فصل أول';
        } else if ($current === 'second-tirm') {
            $semester = 'فصل ثاني';
        }
        if (isset($request->section_id) && isset($request->year_id))
            $courses = Course::where('section_id', $section_id)->whereHas(
                'year_semester',
                fn ($ys) => $ys->whereHas(
                    'year',
                    fn ($year) => $year->where('year_id', $year_id)->where('semester_name', "like", $semester)
                )->with('year')
            )->with('year_semester.year')->get();
        else {
            $courses = Course::with('year_semester.year')->get();
        }
        // info($courses);
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
        $type = $request->type ? 'اختياري' : 'عادي';
        $section_id  = $request->section_id;
        $sy = YearSemester::find($semester_id);

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
                function ($course) use ($request) {
                    $course->where('selection_type', $request->selection_name);
                }
            )->with('course')->get();
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
    public function getStudentStatus($id)
    {
        // $fieldStudentCount = 0;
        // $successStudentCount = 0;
        // $thisYear = Carbon::now()->year - 1;
        // $students = StudentCourses::where('course_id', $id)
        //     ->where('updated_at', ">=", Carbon::createFromDate($thisYear, 1, 1))
        //     ->get()
        //     ->map(function ($student) use (&$fieldStudentCount, &$successStudentCount) {
        //         if ($student->status == 'اول مرة' || $student->status == 'راسب')
        //             $fieldStudentCount++;
        //         else $successStudentCount++;
        //         return $student;
        //     });
        // info($thisYear);
        // info($students);
        // return response()->json([
        //     'f' => $fieldStudentCount,
        //     'p' => $successStudentCount
        // ], 200);

        // $maxMark = StudentCourses::where('course_id', $id)->sum(function($course){
        //     $course->fullMark = $course->mark1 + $course->mark2;
        //     return $course->mark1 + $course->mark2;
        // })->max('fullMark')->get();
        $thisYear = Carbon::now()->year - 1;
        $maxMark = StudentCourses::where('course_id', $id)
            ->where('updated_at', ">=", Carbon::createFromDate($thisYear, 1, 1))->get();
        $maxMark = $maxMark->map(function ($course) {
            $course->fullMark = $course->mark1 + $course->mark2;
            return $course;
        });
        $max = $maxMark->max('fullMark');
        $min = $maxMark->min('fullMark');
        $avg = $maxMark->avg('fullMark');
        $count = $maxMark->count();
        return response()->json([
            'max' => $max,
            'min' => $min,
            'avg' => $avg,
            'count' => $count
        ], 200);
    }

    public function getStudentStatusByYear($id)
    {
        $thisYear = Carbon::now()->year - 1;
        $thisYear = ($thisYear - 1) . '/' . $thisYear;
        $s = 0; // success
        $p = 0; // passed
        $f = 0; // field
        $allStudent = StudentStatus::where('year_date', $thisYear)
            ->where('year_id', $id)->get()->map(function ($student) use (&$s, &$p, &$f) {
                if ($student->status == 'ناجح')
                    $s++;
                else if ($student->status == 'راسب')
                    $f++;
                else $p++;
                return $student;
            });
        return response()->json([
            'success' => $s,
            'passed' => $p,
            'field' => $f,

        ], 200);
    }
}
