{{-- COMMENT AREA --}}
@props(['comments' => $comments, 'task' => $task])
{{-- {{ $task }} --}}
@if ($comments->count())
    @foreach ($comments as $comment)
        <div class="mb-4 ml-4">
            <div class="flex items-center">
                <a href="" class="font-bold text-sm">{{ $comment->user->name }}</a>
                <span class="text-gray-600 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                @auth
                    @can('deleteComment', $comment)
                        <form action="{{ route('comment.delete', $comment) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-500 ml-10 text-xs">Delete</button>
                        </form>
                    @endcan
                @endauth
            </div>
            <p class="mb-2 ml-2 text-sm">{{ $comment->comment }} </p>
        </div>
    @endforeach
@endif
{{-- COMMENT FORM --}}
@auth
    <form action="{{ route('tasks.comment', $task) }}" method="post">
        @csrf
        <div class="mb-4 ml-4">
            <label for="comment" class="sr-only">Comment</label>
            <textarea name="comments[{{ $task->id }}]" id="comment" cols="30" rows="1"
                class="bg-gray-100 border-2 w-full p-4 rounded-lg 
@error('comments.' . $task->id) border-red-500 @enderror"
                placeholder="status on task"></textarea>
            @error('comments.' . $task->id)
                <div class="text-red-500 mt-2 text-sm">
                    {{ $message }}
                </div>
            @enderror
            <button type="submit"
                class="bg-blue-500 text-white font-medium p-3 text-sm mb-4 rounded-lg items-end">Comment</button>
        </div>
    </form>
@endauth
