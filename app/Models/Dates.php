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
        'next_year_first_tirm_start',
        'current'
    ];

    /**
     * current status : [first-tirm , first-tirm-exam ,  first-holiday , second-tirm , final-exam , summer-holiday ]
     * 
     */
}
