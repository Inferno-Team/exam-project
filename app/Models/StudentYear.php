<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentYear extends Model
{
    use HasFactory;
    protected $fillable = ['student_id', 'year_id'];

    public function student(){
        return $this->belongsTo(Student::class,'student_id');
    }
    public function year(){
        return $this->belongsTo(Year::class,'year_id');
    }
}
