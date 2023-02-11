<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_invite_user()
    {
        $project = Project::factory()->create();
        
        $project->invite($newUser = User::factory()->create());

        $this->signIn($newUser);

        $this->post(
            route('projects.tasks.store', $project), 
            $task = ['body' => 'new task']
        );

        $this->assertDatabaseHas('tasks', $task);
    }
}
