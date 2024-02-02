<?php

namespace App\Http\Controllers;

use App\Models\TaskHistory;
use App\Models\User;
use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        $developers = User::where('post', '=', 'D')->get();
        $tasks = Tasks::tasks();
        $taskHistory = TaskHistory::whereIn('status', ['Assigned', 'Transfered'])
            ->latest()
            ->get()
            ->unique('tasks_id');
        return view('tasks.index', [
            'tasks' => $tasks,
            'developers' => $developers,
            'task_history' => $taskHistory,
        ]);
    }
    public function store(Request $request, Tasks $task)
    {
        $this->validate($request, [
            "task" => "required",
        ]);

        $request->user()->tasks()->create([
            'task' => $request->task,
            'developer_id' => 2
        ]);
        $task_id = Tasks::latest()->first()->id;
        $user_id = null;
        $status = 'Unassigned';
        if ($request->assign_to) {
            $user_id = $request->assign_to;
            $status = 'Assigned';
        }

        TaskHistory::create([
            'tasks_id' => $task_id,
            'user_id' => $user_id,
            'status' => $status,
        ]);

        return back();
    }

    public function edit(Tasks $tasks)
    {
        $developers = User::where(['post' => 'D'])->get();
        $task = Tasks::where(['id' => $tasks->id])->first();
        return view('tasks.edit', [
            'developers' => $developers,
            'task' => $task,
        ]);
    }

    public function update(Tasks $tasks, Request $request)
    {
        $this->validate($request, [
            "task" => "required",
        ]);

        $request->user()->tasks()->where(['id' => $tasks->id])->update([
            'task' => $request->task,
            'developer_id' => 1
        ]);
        return redirect('tasks');
    }

    public function loadModel(Tasks $tasks)
    {
        $developers = Tasks::allDevelopers();
        return view('tasks.assign-to-popup', [
            'task' => $tasks,
            'developers' => $developers
        ]);
    }

    public function assign(Request $request, Tasks $tasks)
    {
        $this->validate($request, [
            "assign_to" => 'required',
        ]);
        $tasks->history()->create([
            'user_id' => $request->assign_to,
            'status' => $request->status,
        ]);
        return back();
    }

    public function taskDone(Tasks $tasks)
    {
        $tasks->history()->create([
            'user_id' => auth()->user()->id,
            'tasks_id' => $tasks->id,
            'status' => 'Done',
        ]);
        return back();
    }

    public function destroy(Tasks $tasks, Request $request)
    {
        $request->user()->tasks()->where(['id' => $tasks->id])->delete();
        return back();
    }
}
