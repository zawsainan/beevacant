<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can view category list'
            ], 403);
        }
        return response()->json([
            'categories' => Category::all()
        ], 200);
    }

    public function store(Request $request)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can create a new category'
            ], 403);
        }
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name']
        ]);
        $category = Category::create($attributes);
        return response()->json([
            'category' => $category,
            'message' => 'New category created successfully.'
        ], 201);
    }

    public function update(Request $request, Category $category)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can edit a category'
            ], 403);
        }
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($category->id)]
        ]);
        $category->update($attributes);
        return response()->json([
            'category' => $category,
            'message' => 'New category created successfully.'
        ], 200);
    }
    public function destroy(Request $request, Category $category)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can delete a category'
            ], 403);
        }
        if ($category->jobs()->exists()) {
            return response()->json(['message' => 'Cannot delete category with associated jobs.']);
        }
        $category->delete();
        return response()->json([
            'message' => 'Category is deleted'
        ], 200);
    }
}
