<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentStatus extends Model
{
    use HasFactory;
    protected $table = 'student_status';
    protected $fillable = [
        'student_id',
        'status',
        'year_id',
        'year_date'
    ];

    public function student()
    {
        return $this->hasOne(Student::class, 'student_id');
    }
    public function year(){
        return $this->belongsTo(Year::class,'year_id');
    }
}
