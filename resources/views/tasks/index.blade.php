@extends('layouts.app') @section('content')
<div class="flex justify-center">
    <div class="w-full md:w-8/12 lg:w-8/12 bg-white p-6 mb-4 rounded-lg">
        @auth @if (auth()->user()->post != 'D')
        {{-- TASK FORM --}}
        <form action="{{ route('tasks') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="task" class="sr-only">Body</label>
                <textarea
                    name="task"
                    id="task"
                    cols="30"
                    rows="4"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('task') border-red-500 @enderror"
                    placeholder="Today's Task"
                    autofocus
                ></textarea>
                @error('task')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
                <label for="assign_to" class="sr-only">Assign To</label>
                <select
                    name="assign_to"
                    id="assign_to"
                    class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('assign_to') border-red-500 @enderror"
                >
                    <option value="">Assign To</option>
                    @if ($developers->count()) @foreach ($developers as
                    $developer)
                    <option value="{{ $developer->id }}">
                        {{ $developer->name }}
                    </option>
                    @endforeach @endif
                </select>
                @error('assign_to')
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="flex items-center justify-end">
                <button
                    type="submit"
                    class="bg-blue-500 text-white font-medium p-3 mb-4 rounded-lg justify-end"
                >
                    Create
                </button>
            </div>
        </form>
        @endif @endauth
        {{-- TASK AREA --}}

        @if ($tasks->count()) @auth @if (auth()->user()->post === 'D')
        <h1 class="text-2xl font-bold">My Tasks</h1>
        @foreach ($tasks as $task) @if($task->isAssignedTo() ==
        auth()->user()->id && !$task->done())
        <x-task
            :task="$task"
            :developers="$developers"
            :taskhistory="$task_history"
        />
        <x-comment :comments="$task->comments" :task="$task" />
        @endif @endforeach Others Tasks : @foreach ($tasks as $task)
        @if($task->isAssignedTo() != auth()->user()->id && !$task->done())
        <x-task
            :task="$task"
            :developers="$developers"
            :taskhistory="$task_history"
        />
        <x-comment :comments="$task->comments" :task="$task" />
        @endif @endforeach @else @foreach ($tasks as $task) @if(!$task->done())
        <x-task
            :task="$task"
            :developers="$developers"
            :taskhistory="$task_history"
        />
        <x-comment :comments="$task->comments" :task="$task" />
        @endif @endforeach @endif @endauth @guest @foreach ($tasks as $task)
        @if(!$task->done())
        <x-task
            :task="$task"
            :developers="$developers"
            :taskhistory="$task_history"
        />
        <x-comment :comments="$task->comments" :task="$task->task" />
        @endif @endforeach @endguest @else
        <p>No Tasks.</p>
        @endif
        {{-- PAGINATION --}}
        {{ $tasks->links() }}
    </div>
</div>
@auth @if(auth()->user()->post !== 'D')
<x-call-meeting :developers="$developers" />
@endif @endauth @endsection
