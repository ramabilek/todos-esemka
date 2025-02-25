<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Tasks::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): ?JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'list_id' => 'exists:list,id',
        ]);

        $tasks = Tasks::create($validatedData);

        return response()->json([
            'message' => 'Task created successfully!',
            'tasks' => $tasks
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $task = Tasks::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'name' => 'string|nullable',
            'list_id' => 'nullable|exists:list,id',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['message' => 'Task status updated successfully', 'task' => $task]);
    }

    public function delete($id): JsonResponse
    {
        $list = Tasks::find($id);

        if (!$list) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $list->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
