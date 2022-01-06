<?php

namespace App\Http\Controllers;

use App\Models\Section;

class SectionController extends Controller
{
    public function getSections()
    {
        $sections = Section::get();
        return response()->json($sections, 200);
    }
}
