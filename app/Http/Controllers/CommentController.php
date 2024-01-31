<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Tasks;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Tasks $tasks, Request $request)
    {
        $this->validate($request, [
            "comments.*" => "required",
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'comments.*.required' => 'The field for comment is required.',
        ]);
        foreach ($request->comments as $comment) {
            if ($request->image) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads'), $imageName);
                $attachment = 'uploads/' . $imageName;
            } else {
                $attachment = null;
            }

            $tasks->comments()->create([
                'user_id' => $request->user()->id,
                'comment' => $comment,
                'attachment' => $attachment,
            ]);
        }
        return back()->with('success', 'Comment Added Successfully');
    }

    public function destroy(Comment $comment, Request $request)
    {
        $request->user()->comments()->where(['id' => $comment->id])->delete();
        return back();
    }
}
