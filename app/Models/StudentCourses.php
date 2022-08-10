<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourses extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id', 'course_id', 'status', 'mark1', 'mark2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
