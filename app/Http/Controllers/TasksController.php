<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Tasks::all());
    }

    public function create(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'list_id' => 'required|exists:list,id',
            'time' => 'required|date_format:H:i',
            'status' => 'in:completed,in progress',
        ]);

        $task = Tasks::create($validatedData);

        return response()->json([
            'message' => 'Task created successfully!',
            'task' => $task
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
            'time' => 'date_format:H:i',
            'status' => 'in:completed,in progress',
        ]);

        $task->update(['status' => $request->status]);

        return response()->json(['message' => 'Task status updated successfully', 'task' => $task]);
    }


    public function delete($id): JsonResponse
    {
        $task = Tasks::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
