<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMarks extends Model
{
    use HasFactory;
    protected $fillable = [
        'mark',
        'cs_id',
        'type',
    ];

    public function student_course(){
        return $this->belongsTo(StudentCourses::class,'cs_id');
    }
    
}
