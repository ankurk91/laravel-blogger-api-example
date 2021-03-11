<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate();

        return response()->json([
            'data' => $categories,
        ]);
    }

    public function store(CreateRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'data' => $category->refresh(),
        ]);
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => $category,
        ]);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'data' => $category->refresh(),
        ]);
    }

    public function destroy(Category $category)
    {
        DB::beginTransaction();

        $category->posts()->detach();
        $category->delete();

        DB::commit();

        return response()->noContent();
    }
}
