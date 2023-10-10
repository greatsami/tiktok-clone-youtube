<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class GlobalController extends Controller
{
    public function getRandomUsers()
    {
        try {
            $suggested = User::inRandomOrder()->limit(5)->get();
            $following = User::inRandomOrder()->limit(10)->get();

            return response()->json([
                'suggested' => new UserCollection($suggested),
                'following' => new UserCollection($following),
            ], 200);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}
