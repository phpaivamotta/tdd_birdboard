<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project_generates_activity()
    {
        $this->withoutExceptionHandling();
    
        $project = ProjectFactory::create();
        
        $this->assertCount(1, $project->activities);
        $this->assertEquals('created', $project->activities->first()->description);
    }

    public function test_updating_a_project_generates_activity()
    {
        $this->withoutExceptionHandling();
    
        $project = ProjectFactory::create();
        
        $project->update(['title' => 'changed title']);

        $this->assertDatabaseCount('activities', 2);
        $this->assertDatabaseHas('activities', ['description' => 'created']);
        $this->assertDatabaseHas('activities', ['description' => 'updated']);
    }
}
