<?php

namespace App\Http\Controllers;

use App\Models\Lists;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Lists::all();
    }

    public function create(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $list = Lists::create($validatedData);

        return response()->json([
            'message' => 'List created successfully!',
            'list' => $list
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $list = Lists::find($id);

        if (!$list) {
            return response()->json(['message' => 'List not found'], 404);
        }

        $request->validate([
            'name' => 'string|required',
        ]);

        $list->update(['name' => $request->name]);

        return response()->json(['message' => 'List status updated successfully', 'list' => $list]);
    }

    public function delete($id): JsonResponse
    {
        $list = Lists::find($id);

        if (!$list) {
            return response()->json(['message' => 'List not found'], 404);
        }

        $list->delete();
        return response()->json(['message' => 'List deleted successfully']);
    }
}
