<?php

namespace App\Http\Controllers;

use App\Jobs\CheckStudents;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function index()
    {
        CheckStudents::dispatch();
        return view('spa');
    }
}
