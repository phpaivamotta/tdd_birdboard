<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project_records_activity()
    {
        $this->withoutExceptionHandling();
    
        $project = ProjectFactory::create();
        
        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities->first()->description);
    }

    public function test_updating_a_project_records_activity()
    {
        $this->withoutExceptionHandling();
    
        $project = ProjectFactory::create();
        
        $project->update(['title' => 'changed title']);

        $this->assertDatabaseCount('activities', 2);
        $this->assertDatabaseHas('activities', ['description' => 'created']);
        $this->assertDatabaseHas('activities', ['description' => 'updated']);
    }

    public function test_creating_new_task_records_project_activity()
    {
        $project = ProjectFactory::create();
        $project->addTask('some task');
    
        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('some task', $activity->subject->body);
        });
    }

    public function test_completing_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activities);

        tap($project->activities->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    public function test_incompleting_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();
        
        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->fresh()->activities);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $this->assertCount(4, $project->fresh()->activities);
        $this->assertEquals('incompleted_task', $project->fresh()->activities->last()->description);
    }

    public function test_deleting_a_task_records_activity()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->delete();

        $this->assertCount(3, $project->activities);
    }
}
