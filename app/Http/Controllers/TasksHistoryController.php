<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasksHistoryController extends Controller
{
    public function store(Request $request)
    {
        $request->tasks()->history()->create([
            'user_id' => $request->assign_to,
            'status' => 'Assigned'
        ]);
        return back();
    }
}
