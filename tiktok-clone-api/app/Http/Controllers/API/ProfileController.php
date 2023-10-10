<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Http\Resources\UserCollection;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($id)
    {
        try {
            $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            $user = User::where('id', $id)->get();

            return response()->json([
                'posts' => new PostCollection($posts),
                'user' => new UserCollection($user),
            ], 200);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
