<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4',
            'text' => 'required'
        ]);

        try {
            $post = new Post;
            $post = (new FileService)->addVideo($post, $request);
            $post->user_id = auth()->user()->id;
            $post->text = $request->input('text');
            $post->save();

            return response()->json(['success' => 'OK'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::where('id', $id)->get();
            $posts = Post::where('user_id', $post[0]->user_id)->get();

            $ids = $posts->map(function ($post) {
                return $post->id;
            });

            return response()->json([
                'post' => new PostCollection($post),
                'ids' => $ids,
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);
            if(!is_null($post->video) && file_exists(public_path() . '/files/'. $post->video)) {
                unlink(public_path() . '/files/' . $post->video);
            }
            $post->delete();

            return response()->json(['success' => 'OK'], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
