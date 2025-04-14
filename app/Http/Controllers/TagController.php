<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can view tag list'
            ], 403);
        }
        return response()->json([
            'tags' => Tag::all()
        ], 200);
    }

    public function store(Request $request)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can create a new tag'
            ], 403);
        }
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name']
        ]);
        $tag = Tag::create($attributes);
        return response()->json([
            'tag' => $tag,
            'message' => 'New tag created successfully.'
        ], 201);
    }

    public function update(Request $request, Tag $tag)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can edit a tag'
            ], 403);
        }
        $attributes = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tags')->ignore($tag->id)]
        ]);
        $tag->update($attributes);
        return response()->json([
            'tag' => $tag,
            'message' => 'Tag updated successfully.'
        ], 200);
    }
    public function destroy(Request $request, Tag $tag)
    {
        if ($request->user()->role() !== 'admin') {
            return response()->json([
                'message' => 'Only admin can delete a tag'
            ], 403);
        }
        if ($tag->jobs()->exists()) {
            return response()->json(['message' => 'Cannot delete tag with associated jobs.']);
        }
        $tag->delete();
        return response()->json([
            'message' => 'tag is deleted'
        ], 200);
    }
}
