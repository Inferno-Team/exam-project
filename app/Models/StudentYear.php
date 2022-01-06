<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentYear extends Model
{
    protected $table = 'student_year';
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'year_id',
        'created_at',
        'updated_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
}
