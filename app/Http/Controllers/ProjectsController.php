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
        if ($project->owner_id !== auth()->user()->id) {
            return abort(403);
        }

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

        $attributes['owner_id'] = auth()->user()->id;

        $project = Project::create($attributes);

        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }
}
