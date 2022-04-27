<?php

namespace App\Http\Controllers;

use App\Models\Year;
use App\Models\YearSemester;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function get_years()
    {
        $years = Year::get();
        return response()->json([
            'years' => $years
        ], 200);
    }
    public function get_semesters($year_id)
    {
        $semesters = YearSemester::where('year_id',$year_id)->get();
        
        return response()->json([
            'years' => $semesters
        ], 200);
    }
    
    public function getYear($id)
    {
        $year = Year::where('id', $id)->first();
        return response()->json([
            'year' => $year
        ], 200);
    }
}
