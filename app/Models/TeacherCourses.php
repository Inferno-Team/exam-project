<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourses extends Model
{
    use HasFactory;
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function doctor()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    
}
