<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    public function test_a_user_can_create_a_task()
    {
        $this->withoutExceptionHandling();

        // create and log user
        $this->signIn();

        // create project
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        // post to route
        $this->post($project->path() . '/tasks', ['body' => 'my task']);

        // assert task can be seen
        $this->get($project->path())->assertSee('my task');
    }

    public function test_a_task_requires_a_body()
    {
        $this->signIn();

        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $task = Task::factory()->raw(['project_id' => $project->id, 'body' => '']);

        $this->post($project->path() . '/tasks', $task)->assertSessionHasErrors('body');
    }
}
