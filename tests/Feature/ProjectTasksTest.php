<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    public function test_guest_cannot_add_task_to_project()
    {
        $project = Project::factory()->create();

        $task = Task::factory()->raw(['project_id' => $project->id]);

        $this->post($project->path() . '/tasks', $task)->assertRedirectToRoute('login');
    }

    public function test_only_the_owner_of_the_project_may_add_tasks()
    {
        $this->signIn();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Non owner task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Non owner task']);
    }

    public function test_only_the_owner_of_the_project_may_update_a_tasks()
    {
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed task'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed task']);
    }

    public function test_a_project_can_have_tasks()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    public function test_a_user_can_create_a_task()
    {
        // create and log user
        $this->signIn();

        // create project
        $project = Project::factory()->create(['owner_id' => auth()->id()]);

        // post to route
        $this->post($project->path() . '/tasks', ['body' => 'my task']);

        // assert task can be seen
        $this->get($project->path())->assertSee('my task');
    }

    public function test_a_task_can_be_updated()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'changed task',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed task',
        ]);
    }

    public function test_a_task_can_be_completed()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_a_task_can_be_marked_as_incomplete()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    public function test_a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $task = Task::factory()->raw(['project_id' => $project->id, 'body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $task)
            ->assertSessionHasErrors('body');
    }
}
