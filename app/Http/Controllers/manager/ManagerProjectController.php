<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\TempImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

class ManagerProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('tasks')->withCount([
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('completed', true);
            }
        ])->paginate(15);
        return View('manager.projects.index', compact('projects'));
    }


    public function create()
    {
        $users = User::latest('id', 'ASC')->get();
        return View('manager.projects.create', compact('users'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_title' => 'required|string|max:255',
            'project_description' => 'nullable|string',
            'user_id' => 'required',
            'image_id' => 'required'
        ]);

        if ($validator->passes()) {
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
            $project = new Project([
                'project_title' => $request->input('project_title'),
                'project_description' => $request->input('project_description'),
                'project_image' => '/uploads/project/thumb/' . $newImageName,
                'user_id' => $request->input('user_id'),
            ]);
            $project->save();



            return redirect()->route('project.index')->with('success', 'Project created successfully');
        } else {
            return back()->withErrors($validator)->withInput();
        }


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
}