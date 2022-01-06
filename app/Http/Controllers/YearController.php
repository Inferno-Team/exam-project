<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function get_years(){
        $years = Year::get();
        return response()->json([
            'years'=>$years
        ],200);
    }
}
