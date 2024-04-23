<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Blog;

class CommentController extends Controller
{
    public function saveComment(Request $request, $blog_id) {
        $blog = Blog::find($blog_id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog does not exist"
            ], 404);
        }

        $fields = $request->validate([
            "body" => "required",
            "comment_id" => "nullable"
        ]);

        Comment::create([
            "body" => $fields["body"],
            "user_id" => auth()->user()->id,
            "blog_id" => isset($fields["comment_id"]) ? null : $blog_id,
            "comment_id" => $fields["comment_id"],
        ]);

        return response()->json([
            "message" => "Your comment has been posted"
        ], 201);
    }

    public function updateComment(Request $request, $blog_id, $comment_id) {
        $comment = Comment::find($comment_id);

        if (!$comment) {
            return response()->json([
                "message" => "Comment does not exist"
            ], 404);
        }

        $blog = Blog::find($blog_id);

        if (!$blog) {
            return response()->json([
                "message" => "Blog does not exist"
            ], 404);
        }

        $fields = $request->validate([
            "body" => "required",
        ]);

        $comment->body = $fields["body"];
        $comment->save();

        return response()->json([
            "message" => "Your comment has been updated"
        ], 201);
    }

    public function deleteComment($blog_id, $comment_id) {
        $comment = Comment::find($comment_id);

        if (!$comment) {
            return response()->json([
                "message" => "Comment does not exist"
            ], 404);
        }

        $comment->delete();

        return response()->json([
            "message" => "Comment has been deleted"
        ], 200);
    }
}
