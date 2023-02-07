<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate([
            'body' => ['required']
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        request()->validate([
            'body' => ['required']
        ]);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed') // need the ->has() method to see if box was checked, because otherwise this field is not sent through
        ]);

        return redirect($project->path());
    }
}
