<?php

namespace App\Http\Controllers;

use App\Jobs\CheckCurrentTime;
use App\Jobs\CheckStudents;
use App\Jobs\CheckStudentStatus;

class SpaController extends Controller
{
    public function index()
    {
        CheckCurrentTime::dispatch();
        CheckStudentStatus::dispatch();
        CheckStudents::dispatch();
        return view('spa');
    }
}
