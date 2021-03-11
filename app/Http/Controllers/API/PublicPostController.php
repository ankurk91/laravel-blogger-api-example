<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PublicPostController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'search' => ['nullable', 'string', 'max:255'],
        ]);

        $posts = Post::query()
            ->with(['categories', 'user']);

        if ($request->filled('search')) {
            $posts->where(function (Builder $query) use ($request) {
                $query->where('title', 'like', '%'.$request->input('search').'%')
                    ->orWhere('body', 'like', '%'.$request->input('search').'%');
            });
        }

        $posts = $posts->published()->latest()->paginate();

        return response()->json([
            'data' => $posts,
        ]);
    }
}
