<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentYear;
use App\Models\Year;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getAllStudent()
    {
        $users = Student::with('year.year')->get();
        return response()->json($users, 200);
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
}
