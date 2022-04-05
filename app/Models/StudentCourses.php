<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourses extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'course_id', 'status'
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'student_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function marks()
    {
        return $this->hasMany(StudentMarks::class, 'cs_id');
    }
}
