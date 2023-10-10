<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($post) {
            return [
                'id' => $post->id,
                // 'user_id' => $post->user->name,
                'text' => $post->text,
                'video' => config('app.url').'/'.$post->video,
                'created_at' => $post->created_at->format(' M D Y'),
                'updated_at' => $post->updated_at->format(' M D Y'),

                'comments' => $post->comments->map(function ($comment) {
                    return [
                        'id' => $comment->id,
                        'text' => $comment->text,
                        'user' => [
                            'id' => $comment->user->id,
                            'name' => $comment->user->name,
                            'image' => config('app.url').'/'.$comment->user->image,
                        ],
                    ];
                }),

                'likes' => $post->likes->map(function ($like) {
                    return [
                        'id' => $like->id,
                        'user_id' => $like->user_id,
                        'post_id' => $like->post_id,
                    ];
                }),

                'user' => [
                    'id' => $post->user->id,
                    'name' => $post->user->name,
                    'image' => config('app.url').'/'.$post->user->image,
                ]
            ];
        })->toArray();
    }
}
