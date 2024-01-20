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
        ], [
            'comments.*.required' => 'The field for comment is required.',
        ]);
        foreach ($request->comments as $comment) {
            $tasks->comments()->create([
                'user_id' => $request->user()->id,
                'comment' => $comment,
            ]);
        }
        return back();
    }

    public function destroy(Comment $comment, Request $request)
    {
        $request->user()->comments()->where(['id' => $comment->id])->delete();
        return back();
    }
}
