<?php

namespace App\Http\Controllers;

use App\Jobs\CheckCurrentTime;
use App\Jobs\CheckStudents;
use App\Jobs\CheckStudentStatus;
use App\Jobs\InsertAllCoursesToStudentsOnce;
use App\Jobs\InsertStudentsMarks;
use App\Jobs\InsertStudentsStatus;

class SpaController extends Controller
{
    public function index()
    {
        // CheckCurrentTime::dispatch();
        // CheckStudentStatus::dispatch();
        // CheckStudents::dispatch();   
        // InsertAllCoursesToStudentsOnce::dispatch();
        // InsertStudentsMarks::dispatch();
        // InsertStudentsStatus::dispatch();
        return view('spa');
    }
}
