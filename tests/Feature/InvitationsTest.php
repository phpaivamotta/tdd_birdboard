<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_owners_may_not_invite_users()
    {
        $project = ProjectFactory::create();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }

    public function test_a_project_owner_can_invite_a_user()
    {
        $this->withoutExceptionHandling();
    
        $project = ProjectFactory::create();
        
        $userToInvite = User::factory()->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    public function test_the_invited_email_address_must_be_aassociated_with_a_valid_birdboard_account()
    {
        $project = ProjectFactory::create();
        
        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
            'email' => 'notauser@email.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account.'
            ]);
    }

    public function test_invited_users_can_update_project_details()
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
