<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    protected $table = 'years';
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public function student_year()
    {
        return $this->hasMany(StudentYear::class, 'year_id');
    }

    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_years', 'year_id', 'student_id');
    }
    
}
