<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearSemester extends Model
{
    use HasFactory;
    protected $fillable = [
        'year_id', 'semester_id', 'name'
    ];
    public function year(){
        return $this->belongsTo(Year::class,'year_id');
    }
    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id');
    }
    
}
