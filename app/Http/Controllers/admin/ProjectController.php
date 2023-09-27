<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\TempImage;
use App\Models\User;
use Illuminate\Http\Request;
use Image;

class ProjectController extends Controller
{
    public function index()
    {
        /* $projects = Project::paginate(10);
        foreach ($projects as $project) {
            $projectId = $project->id;
            $completedTaskCount = Task::where('project_id', $projectId)->count();
            dd($completedTaskCount);
        }
        return View('admin.project.index', ['projects' => $projects]); */

        $projects = Project::withCount('tasks')->withCount([
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('completed', true);
            }
        ])->paginate(15);
        return View('admin.project.index', compact('projects'));


    }


    public function create()
    {
        $users = User::latest('id', 'ASC')->get();
        return View('admin.project.create', compact('users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'project_title' => 'required|string|max:255',
            'project_description' => 'nullable|string',
        ]);

        if ($request->image_id) {
            $tempImage = TempImage::find($request->image_id);
            $extArray = explode('.', $tempImage->name);
            $ext = last($extArray);
            $projectTitle = $request->input('project_title');
            $optimizedTitle = preg_replace('/[^\p{L}\p{N}]+/u', '_', $projectTitle);
            $newImageName = strtolower($optimizedTitle . '_' . $request->image_id . '.' . $ext);
            $sPath = public_path() . '/temp/' . $tempImage->name;
            $dPath = public_path() . '/uploads/project/thumb/' . $newImageName;
            $img = Image::make($sPath);
            $img->fit(450, 600, function ($constraint) {
                $constraint->upsize();
            });
            $img->save($dPath);
        }

        $project = Project::create([
            'project_title' => $request->input('project_title'),
            'project_description' => $request->input('project_description'),
            'project_image' => '/uploads/project/thumb/' . $newImageName
        ]);

        return back()->with('success', 'Project created successfully');
    }

    public function distroy($id, Request $request)
    {
        $project = Project::find($id);
        if (empty($project)) {
            return back()->withErrors('error', 'No record found');
        } else {
            $project->delete();
            return back()->with('success', 'Project deleted successfully');
        }
    }

    public function addTask($id, Request $request)
    {
        $project = Project::find($id);

        if (empty($project)) {
            return back()->withErrors('error', 'No record found');
        }
        $userId = Auth()->user()->id;
        $projectId = $id;

        $tasks = Task::where('project_id', $projectId)
            ->orderBy('order')
            ->get();
        return View('tasks.index', compact(['tasks', 'project']));
    }
}