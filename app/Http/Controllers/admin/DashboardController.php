<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('tasks')->withCount([
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('completed', true);
            }
        ])->paginate(4);
        return view('admin.dashboard', compact('projects'));
    }
}