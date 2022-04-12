<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Year;
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
    public function get_semesters()
    {
        $semesters = Semester::all();
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
