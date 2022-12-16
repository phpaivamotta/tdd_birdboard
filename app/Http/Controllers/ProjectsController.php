<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => Project::all()
        ]);
    }

    public function show(Project $project)
    {
        return view('projects.show', [
            'project' => $project
            ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'description' => ['required']
        ]);

        auth()->user()->projects()->create($attributes);

        return redirect('/projects');
    }
}
