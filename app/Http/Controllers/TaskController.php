<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::orderBy('order')->get();
        return view('tasks.index', compact('tasks'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'project_id' => $request->input('project_id'),
            'order' => Task::count(),
            // Set the order to the end of the list
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $task]);
    }
    public function updateOrder(Request $request)
    {
        $taskOrder = json_decode($request->input('taskOrder'));

        foreach ($taskOrder as $index => $taskId) {
            Task::where('id', $taskId)->update(['order' => $index]);
        }

        return response()->json(['message' => 'Task order updated successfully']);
    }

    public function toggleCompletion($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->completed = !$task->completed;
        $task->save();

        return response()->json(['message' => 'Task completion status updated successfully']);
    }

}