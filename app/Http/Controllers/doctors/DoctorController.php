<?php

namespace App\Http\Controllers\doctors;

use App\Http\Controllers\Controller;
use App\Models\Supervisor;
use App\Models\Teacher;
use App\Models\TeacherCourses;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function getDoctors()
    {
        $doctors = Teacher::all();
        return response()->json($doctors, 200);
    }
    public function getDoctorById($id)
    {
        $doctor = Teacher::find($id);
        return response()->json($doctor, 200);
    }
    public function getDoctorCourses($id)
    {
        $teacherCourses = TeacherCourses::with('course.year_semester.year')->where('teacher_id', $id)->get();
        $courses = [];
        foreach ($teacherCourses as $tc) {
            array_push($courses, $tc->course);
        }
        return response()->json($courses, 200);
    }
    public function getSupervisors()
    {
        $supervisors = Supervisor::all();
        return response()->json($supervisors, 200);
    }
    public function getSupervisor($id)
    {
        $supervisors = Supervisor::find($id);
        return response()->json($supervisors, 200);
    }
}
