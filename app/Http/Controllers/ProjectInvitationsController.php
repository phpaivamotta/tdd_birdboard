<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{
    public function store(ProjectInvitationRequest $request, Project $project)
    {
        // $this->authorize('update', $project);

        // $request->validate([
        //     'email' => ['required', 'exists:users,email']
        // ], [
        //     'email.exists' => 'The user you are inviting must have a Birdboard account.'
        // ]);

        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
