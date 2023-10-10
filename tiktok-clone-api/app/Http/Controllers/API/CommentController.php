<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Models\Comment;
use App\Models\Post;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
            'comment' => 'required'
        ]);

        try {
            $comment = new Comment();
            $comment->user_id = auth()->id();
            $comment->post_id = $request->input('post_id');
            $comment->text = $request->input('comment');
            $comment->save();

            return response()->json(['success' => 'OK'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return response()->json(['success' => 'OK'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
