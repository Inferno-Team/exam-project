<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use App\Models\StudentCourses;
use App\Models\StudentMarks;
use App\Models\StudentYear;
use App\Models\StudentYearsHistory;
use App\Models\Year;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAllStudent($year)
    {
        $students = Student::whereHas('year', fn ($query) => $query
            ->where('year_id', $year)->with('year'))->with('year.year')->get();
        return response()->json(['students' => $students], 200);
    }

    public function addStudent(Request $request)
    {
        $student = Student::create([
            'univ_id' => $request->univ_id,
            'name' => $request->name,
            'father_name' => $request->father_name,
            'last_name' => $request->last_name,
            'mother_name' => $request->mother_name,
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'field_number' => $request->field_number,
            'recruitment_division' => $request->recruitment_division,
            'address' => $request->address,
        ]);
        $studentYear = StudentYear::create([
            'student_id' => $student->id,
            'year_id' => Year::where('name', $request->year_name)->first()->id
        ]);
        return response()->json([
            'msg' => 'تمت إضافة الطالب بنجاح'
        ], 200);
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $last_name = $request->l_name;
        $father_name = $request->f_name == '' ? $last_name : $request->f_name;
        $students = Student::where('name', 'like', '%' . $name . '%')
            ->where('father_name', 'like', '%' . $father_name . '%')
            ->where('last_name', 'like', '%' . $last_name . '%')
            ->with('year.year')->get();
        return response()->json(['data' => $students], 200);
    }

    public function searchUniv(Request $request)
    {
        $univ_id = $request->id;
        $students = Student::where('univ_id', 'like', $univ_id . '%')
            ->with('year.year')->get();
        return response()->json(['data' => $students], 200);
    }
    public function getStudentById($id)
    {

        $student = Student::where('univ_id', $id)
            ->with('year.year')->first();
        return response()->json($student, 200);
    }
    public function getYear($id)
    {
        $sy = StudentYear::where('student_id', $id)->with('year')->first();
        return response()->json([
            'year' => $sy->year
        ], 200);
    }
    public function getFirstYear($id)
    {
        $sy = StudentYearsHistory::where('student_id', $id)->where('year_id', 1)->first();
        return response()->json([
            'year' => $sy->year_date
        ], 200);
    }
    public function getCourses($id)
    {
        $sc = StudentCourses::where('student_id', $id)->with(['marks', 'course'])->get();
        return response()->json($sc, 200);
    }

    public function getYearMarks($id, $year_id)
    {
        $sc = StudentCourses::where('student_id', $id)->with('marks', 'course')->get();
        $sc = $sc->where('course.year_id', $year_id);

        return response()->json(array_values($sc->toArray()), 200);
    }
    public function getYearHistory($id, $year_id)
    {
        $history = StudentYearsHistory::where('student_id', $id)
            ->where('year_id', $year_id)->first();
        return response()->json($history, 200);
    }



    public function addMark1(Request $request)
    {
        $student_id = $request->student_id;

        $course_id = $request->course_id;
        $mark = $request->mark;
        $courseStudent = StudentCourses::where('student_id', $student_id)
            ->where('course_id', $course_id)->first();
        if ($courseStudent->status == 'ناجح') {
            return response([
                'code' => 300,
                'message' => 'هذا الطالب ناجح في هذه المادة من قبل'
            ], 200);
        } else {
            $studentMark = StudentMarks::create([
                'cs_id' => $courseStudent->id,
                'mark' => $mark,
                'type' => 'عملي'
            ]);
            return response()->json([
                'code' => 200,
                'message' => 'تم إضافة العلامة بنجاح'
            ], 200);
        }
    }
    public function addMark2(Request $request)
    {
        $student_id = $request->student_id;

        $course_id = $request->course_id;
        $mark = $request->mark;
        $courseStudent = StudentCourses::where('student_id', $student_id)
            ->where('course_id', $course_id)->first();
        if ($courseStudent->status == 'ناجح') {
            return response([
                'code' => 300,
                'message' => 'هذا الطالب ناجح في هذه المادة من قبل'
            ], 200);
        } else {
            $courseStudentMark1 = StudentMarks::where('cs_id', $courseStudent->id)
                ->where('type', 'عملي')->first();
            $studentMark = StudentMarks::create([
                'cs_id' => $courseStudent->id,
                'mark' => $mark,
                'type' => 'نظري'
            ]);
            $fullMark = $mark + $courseStudentMark1->mark;
            if ($fullMark > 59) {
                $courseStudent->status = 'ناجح';
                $courseStudent->save();
            } else {
                $courseStudent->status = 'راسب';
                $courseStudent->save();
            }
            return response()->json([
                'code' => 200,
                'message' => 'تم إضافة العلامة بنجاح'
            ], 200);
        }
    }
}
