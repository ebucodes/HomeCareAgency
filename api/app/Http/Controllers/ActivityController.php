<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    //
    public function allLogs()
    {
        $logs = Activity::all();
    }

    //
    public function userLog()
    {
        $logs = Activity::where('user', auth()->user()->userName)->get();
    }
}
