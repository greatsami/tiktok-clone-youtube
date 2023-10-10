<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loggedInUser()
    {
        try {
            $user = User::whereId(auth()->id())->get();
            return response()->json(new UserCollection($user), 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function updateUserImage(Request $request)
    {
        $request->validate(['image' => 'required|mimes:png,jpeg,jpg']);
        if ($request->height === '' || $request->width === '' || $request->top === '' || $request->left === '') {
            return response()->json(['error' => 'The dimensions are incomplete'], 400);
        }

        try {
            $user = (new FileService)->updateImage(auth()->user(), $request);
            $user->save();

            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['success' => 'OK', 'user' => $user], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function updateUser(Request $request)
    {
        $request->validate(['name' => 'required']);

        try {
            $user = User::findOrFail(auth()->id());
            $user->name = $request->input('name');
            $user->bio = $request->input('bio');
            $user->save();

            return response()->json(['success' => 'OK'], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
