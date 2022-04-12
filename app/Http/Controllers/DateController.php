<?php

namespace App\Http\Controllers;

use App\Models\Dates;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function getDates()
    {
        $time =  Dates::first();
        return response()->json(
            $time,
            200
        );
    }
    public function setDates(Request $request)
    {
        $date = Dates::first();
        $kv = explode(':', $request[0]);

        // return response()->json($kv, 200);
        // $arr = json_encode($request->all());
        // return response()->json($arr, 200);
        if (isset($date)) {
            $date->update([
                $kv[0] => $kv[1]
            ]);
        } else {
            $date = Dates::create([
                $kv[0] => $kv[1]
            ]);
        }
        return response()->json($date, 200);
    }
}
