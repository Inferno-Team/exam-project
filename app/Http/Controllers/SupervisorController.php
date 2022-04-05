<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupervisorController extends Controller
{
    function addSuper(Request $request)
    {
        $name = $request->name;
        $type = $request->type;
        $user = Auth::user();

        $supervisor = Supervisor::create([
            "name" => $name,
            "type" => $type
        ]);
        return response()->json([
            'msg' => 'supervisor created successfully',
            'user' => $supervisor
        ], 200);
    } 
}
