<?php

namespace App\Http\Controllers;

use App\Models\TaskAssigned;
use App\Models\User;
use App\Notifications\TaskAssigned as NotificationsTaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskAssignedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function taskAssigned(Request $request)
    {
        $task = TaskAssigned::create([
            'user_id' => Auth::user()->id,
            'tasks_id'  => $request->task_id
        ]);
        User::find(Auth::user()->id)->notify(new NotificationsTaskAssigned($task->tasks_id));

        return redirect()->back()->with('status', 'Your task was successful!');
    }
}
