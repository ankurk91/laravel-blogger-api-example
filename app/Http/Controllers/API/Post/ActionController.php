<?php

namespace App\Http\Controllers\API\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Support\Facades\Date;

class ActionController extends Controller
{
    public function publish(Post $post)
    {
        $post->fill([
            'published_at' => Date::now(),
        ]);
        $post->save();

        return response()->json([
            'data' => $post->refresh(),
        ]);
    }

    public function unPublish(Post $post)
    {
        $post->fill([
            'published_at' => null,
        ]);
        $post->save();

        return response()->json([
            'data' => $post->refresh(),
        ]);
    }
}
