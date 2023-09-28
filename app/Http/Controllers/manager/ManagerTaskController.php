<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskImage;
use Illuminate\Http\Request;
use Image;

class ManagerTaskController extends Controller
{

    public function index()
    {
        $tasks = Task::orderBy('order')->get();
        return view('manager.tasks.index', compact('tasks'));
    }



    public function create($id, Request $request)
    {
        $project = Project::find($id);
        if (empty($project)) {
            return back()->withErrors('error', 'No record found');
        }
        $userId = Auth()->user()->id;
        $projectId = $project->id;

        $tasks = Task::where('project_id', $projectId)->where('user_id', $userId)
            ->orderBy('order')
            ->get();
        return View('manager.tasks.index', compact(['tasks', 'project']));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if (!$request->image_array) {
            $task = Task::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'project_id' => $request->input('project_id'),
                'order' => Task::count(),
                'user_id' => $request->input('user_id')
            ]);
        } else {
            $task = Task::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'project_id' => $request->input('project_id'),
                'order' => Task::count(),
                'user_id' => $request->input('user_id')
            ]);
            foreach ($request->image_array as $tepm_image_id) {
                $tempImage = TempImage::find($tepm_image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);
                $newImageName = $tepm_image_id . '_' . time() . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/task/image/' . $newImageName;
                $img = Image::make($sPath);
                $img->save($dPath);
                $taskImage = new TaskImage([
                    'task_id' => $task->id,
                    'image' => '/uploads/task/image/' . $newImageName
                ]);
                $taskImage->save();
            }

        }
        return back()->with('success', 'Task added successfully');
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