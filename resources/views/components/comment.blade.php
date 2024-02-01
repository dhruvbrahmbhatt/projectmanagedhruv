{{-- COMMENT AREA --}}
@props(['comments' => $comments, 'task' => $task]) @if ($comments->count())
@foreach ($comments as $comment)
<div class="mb-4 ml-4">
    <div class="flex items-center">
        <a href="" class="font-bold text-sm">{{ $comment->user->name }}</a>
        <span
            class="text-gray-600 text-xs ml-2"
            >{{ $comment->created_at->diffForHumans() }}</span
        >
        @auth @can('deleteComment', $comment)
        <form action="{{ route('comment.delete', $comment) }}" method="post">
            @csrf @method('DELETE')
            <button type="submit" class="text-blue-500 ml-10 text-xs">
                Delete
            </button>
        </form>
        @endcan @endauth
    </div>
    <p class="mb-2 ml-2 text-sm">{{ $comment->comment }}</p>
    @if($comment->attachment)
    <img src="{{ $comment->attachment }}" height="100" width="100" />
    @endif
</div>
@endforeach @endif
{{-- COMMENT FORM --}}
@auth
<form
    action="{{ route('tasks.comment', $task) }}"
    method="post"
    enctype="multipart/form-data"
>
    @csrf
    <div class="mb-4 ml-4">
        <label for="comment" class="sr-only">Comment</label>
        <textarea
            name="comments[{{ $task->id }}]"
            id="comment[{{ $task->id }}]"
            cols="30"
            rows="1"
            class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('comments.' . $task->id) border-red-500 @enderror"
            placeholder="status on task"
        ></textarea>
        <!-- Icon to trigger image upload -->
        <span
            id="uploadIcon"
            class="upload-icon"
            onclick="$('#imageInput{{ $task->id }}').click()"
            >&#x1F4F7;</span
        >
        <!-- Hidden file input for image upload -->
        <input
            type="file"
            id="imageInput{{ $task->id }}"
            name="images[{{ $task->id }}]"
            onchange="previewImage(this, {{ $task->id }});"
            accept="image/*"
            style="display: none"
        />
        @error('comments.' . $task->id)
        <div class="text-red-500 mt-2 text-sm">
            {{ $message }}
        </div>
        @enderror
        <button
            type="submit"
            class="bg-blue-500 text-white font-medium p-3 text-sm mb-4 rounded-lg items-end"
        >
            Comment
        </button>
    </div>
</form>
<button
    id="cancel{{ $task->id }}"
    onclick="cancelImageSelection({{ $task->id }})"
    style="display: none"
>
    X
</button>

<img
    src=""
    alt="Image Preview"
    id="imagePreview{{ $task->id }}"
    style="max-width: 100%; display: none"
    height="100"
    width="100"
/>

<script>
    function previewImage(input, taskId) {
        const fileInput = input;
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                const imagePreview = document.getElementById(
                    "imagePreview" + taskId
                );
                const cancelButton = document.getElementById("cancel" + taskId);
                imagePreview.src = e.target.result;
                imagePreview.style.display = "block";
                cancelButton.style.display = "block";
            };

            reader.readAsDataURL(file);
        }
    }

    function cancelImageSelection(taskId) {
        const fileInput = document.getElementById("imageInput" + taskId);
        const imagePreview = document.getElementById("imagePreview" + taskId);
        const cancelButton = document.getElementById(
            "button[onclick='cancelImageSelection(" + taskId + ")']"
        );

        fileInput.value = null; // Unselect the file
        imagePreview.src = ""; // Clear the preview
        imagePreview.style.display = "none"; // Hide the preview
        cancelButton.style.display = "none"; // Hide the preview
    }
</script>
@endauth
