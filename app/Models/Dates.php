<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dates extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_tirm_start', 'first_tirm_end', 'first_tirm_exam_end',
        'second_tirm_start', 'second_tirm_end', 'second_tirm_exam_end',
        'next_year_first_tirm_start'
    ];
    // protected $casts = [
    //     'first_tirm_start' => 'date:Y-m-d H:00',
    //     'first_tirm_end' => 'datetime:Y-m-d H:00',
    //     'first_tirm_exam_end' => 'datetime:Y-m-d H:00',
    //     'second_tirm_start' => 'datetime:Y-m-d H:00',
    //     'second_tirm_end' => 'datetime:Y-m-d H:00',
    //     'second_tirm_exam_end' => 'datetime:Y-m-d H:00',
    //     'next_year_first_tirm_start' => 'datetime:Y-m-d H:00',
    // ];
}
