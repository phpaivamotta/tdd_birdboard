<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->projects
        ]);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', [
            'project' => $project
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => ['required'],
            'description' => ['required', 'max:100'],
            'notes' => ['min:3', 'max:255']
        ]);

        $attributes['owner_id'] = auth()->user()->id;

        $project = Project::create($attributes);

        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $attributes = $request->validate([
            'notes' => ['min:3', 'max:100']
        ]);

        $project->update($attributes);

        return redirect($project->path());
    }
}
