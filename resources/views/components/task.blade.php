@props(['task' => $task, 'developers' => $developers, 'taskhistory' =>
$taskhistory])
<div class="mb-4">
    <div class="flex items-center">
        <form action="{{ route('tasks.done', $task) }}" method="post">
            @csrf @can('editTask', $task)
            <input
                type="checkbox"
                onChange="this.form.submit()"
                class="text-blue-500 mr-2 text-xs"
            />
            @endcan
        </form>
        <a
            href=""
            class="font-bold text-base"
            >{{ $task->user ? $task->user->name : '' }}</a
        >
        <span
            class="text-gray-600 text-sm ml-2"
            >{{ $task->created_at->diffForHumans() }}</span
        >
        @can('editTask', $task)
        <form action="{{ route('tasks.edit', $task) }}" method="post">
            @csrf
            <button type="submit" class="text-blue-500 ml-10 text-xs">
                Edit
            </button>
        </form>
        @endcan @can('deleteTask', $task)
        <form action="{{ route('tasks.delete', $task) }}" method="post">
            @csrf @method('DELETE')
            <button type="submit" class="text-red-500 ml-2 text-xs">
                Delete
            </button>
        </form>
        @endcan
    </div>
    <p class="mb-2 ml-2 text-lg">{{ $task->task }}</p>
    @php $btnAssignText = '' @endphp @if (!empty($task->history))
    <p class="mb-2 ml-2 text-sm">
        @foreach ($task->history as $history)
        {{ $history->status }} :
        {{ $history->user ? $history->user->name : "Created" }} :
        {{ $history->created_at->format('d/m/y g:i A') }}<br />
        @if($history->status === "Unassigned") @php $btnAssignText = 'Assign'
        @endphp @else @php $btnAssignText = 'Transfer' @endphp @endif
        @endforeach
    </p>
    @auth @can('editTask', $task)
    <x-assign-to-popup
        :developers="$developers"
        :task="$task"
        :btn="$btnAssignText"
    />
    @endcan @endauth @endif
</div>
