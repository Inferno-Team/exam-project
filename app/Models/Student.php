<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'students';

    protected $fillable = [
        'univ_id',
        'name',
        'father_name',
        'last_name',
        'mother_name',
        'birth_place',
        'gender',
        'field_number',
        'recruitment_division',
        'address',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function year()
    {
        return $this->hasOne(StudentYear::class,'student_id');
    }

    public function year_history(){
        return $this->hasOne(StudentStatus::class,'student_id');
    }

    public function courses(){
        return $this->hasMany(StudentCourses::class,'student_id');
    }

}
