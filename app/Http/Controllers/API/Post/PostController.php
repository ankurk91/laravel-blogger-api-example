<?php

namespace App\Http\Controllers\API\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreateRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $request->user();
        $posts = $user->posts()->latest()->paginate();

        return response()->json([
            'data' => $posts,
        ]);
    }

    public function store(CreateRequest $request)
    {
        $post = new Post();
        $post->fill($request->validated());

        if ($request->boolean('publish')) {
            $post->fill([
                'published_at' => Date::now(),
            ]);
        }

        $post->user()->associate($request->user());
        $post->save();

        if ($request->filled('categories')) {
            $post->categories()->attach($request->input('categories'));
        }

        return response()->json([
            'data' => $post->refresh(),
        ]);
    }

    public function show(Post $post)
    {
        $post->loadMissing('user', 'categories');

        return response()->json([
            'data' => $post,
        ]);
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $post->update($request->validated());

        if ($request->filled('categories')) {
            $post->categories()->attach($request->input('categories'));
        }

        return response()->json([
            'data' => $post->refresh(),
        ]);
    }

    public function destroy(Post $post)
    {
        DB::beginTransaction();

        $post->categories()->detach();
        $post->delete();

        DB::commit();

        return response()->noContent();
    }
}
