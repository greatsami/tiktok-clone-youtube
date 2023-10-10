<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
        ]);

        try {
            $like = new Like();
            $like->user_id = auth()->id();
            $like->post_id = $request->input('post_id');
            $like->save();

            return response()->json([
                'like' => [
                    'id' => $like->id,
                    'post_id' => $like->post_id,
                    'user_id' => $like->user_id,
                ],
                'success' => 'OK'
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $like = Like::find($id);
            if (count(collect($like)) > 0) {
                $like->delete();
            }

            return response()->json([
                'like' => [
                    'id' => $like->id,
                    'post_id' => $like->post_id,
                    'user_id' => $like->user_id
                ],
                'success' => 'OK'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

    }
}
