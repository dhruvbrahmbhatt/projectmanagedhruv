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
    id="commentForm"
    action="{{ route('tasks.comment', $task) }}"
    method="post"
    enctype="multipart/form-data"
>
    @csrf
    <div class="mb-4 ml-4">
        <label for="comment" class="sr-only">Comment</label>
        <textarea
            name="comments[{{ $task->id }}]"
            id="comment"
            cols="30"
            rows="1"
            class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('comments.' . $task->id) border-red-500 @enderror"
            placeholder="status on task"
        ></textarea>
        <!-- Icon to trigger image upload -->
        <span id="uploadIcon" class="upload-icon">&#x1F4F7;</span>
        <!-- Hidden file input for image upload -->
        <input
            type="file"
            id="imageInput"
            name="image"
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
            id="submitComment"
        >
            Comment
        </button>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Add this script at the end of your Blade view file or in a separate JavaScript file -->
<script>
    $(document).ready(function () {
        // Get the form and input elements
        var commentForm = $("#commentForm");
        var uploadIcon = $("#uploadIcon");
        var imageInput = $("#imageInput");
        var submitButton = $("#submitComment");

        // Add click event listener to the icon
        uploadIcon.click(function () {
            // Trigger the click event on the hidden file input
            imageInput.click();
        });

        // Handle file input change event
        imageInput.change(function () {
            // You can add additional logic here if needed
            console.log("File selected:", imageInput[0].files[0].name);
        });

        // Handle form submission
        submitButton.click(function () {
            // Disable the submit button or perform any other actions before AJAX
            submitButton.prop("disabled", true);

            // Create a FormData object to send both comment and image
            var formData = new FormData(commentForm[0]);
            formData.append("_token", "{{ csrf_token() }}");

            // Perform AJAX request to handle image upload
            $.ajax({
                url: '{{ route("tasks.comment", $task) }}',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    // Handle the response as needed (e.g., update form fields)
                    // console.log(response);
                    location.reload();
                },
                error: function (error) {
                    console.error("Error uploading image:", error);
                },
                complete: function () {
                    // Enable the submit button or perform any other post-AJAX actions
                    submitButton.prop("disabled", false);
                },
            });
        });
    });
</script>

@endauth
