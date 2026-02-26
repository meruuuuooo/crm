<?php

use App\Models\Crm\Project;
use App\Models\Crm\Contact;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list projects', function () {
    Project::create(['name' => 'Alpha Project', 'status' => 'In Progress']);

    $this->get(route('crm.projects.index'))
        ->assertOk()
        ->assertSee('Alpha Project');
});

it('can show the create project form', function () {
    $this->get(route('crm.projects.create'))->assertOk();
});

it('can create a project', function () {
    $this->post(route('crm.projects.store'), [
        'name'           => 'New Project',
        'project_type'   => 'External',
        'project_timing' => 'Fixed',
        'priority'       => 'High',
        'status'         => 'Not Started',
    ])->assertRedirect(route('crm.projects.index'));

    $this->assertDatabaseHas('crm_projects', ['name' => 'New Project']);
});

it('requires name to create a project', function () {
    $this->post(route('crm.projects.store'), [
        'status' => 'Not Started',
    ])->assertSessionHasErrors('name');
});

it('can show a project', function () {
    $project = Project::create(['name' => 'Show Project', 'status' => 'In Progress']);

    $this->get(route('crm.projects.show', $project))
        ->assertOk()
        ->assertSee('Show Project');
});

it('can show the edit project form', function () {
    $project = Project::create(['name' => 'Edit Project', 'status' => 'Not Started']);

    $this->get(route('crm.projects.edit', $project))
        ->assertOk()
        ->assertSee('Edit Project');
});

it('can update a project', function () {
    $project = Project::create(['name' => 'Old Project', 'status' => 'Not Started']);

    $this->put(route('crm.projects.update', $project), [
        'name'   => 'Updated Project',
        'status' => 'Completed',
    ])->assertRedirect(route('crm.projects.index'));

    $this->assertDatabaseHas('crm_projects', ['id' => $project->id, 'name' => 'Updated Project', 'status' => 'Completed']);
});

it('can delete a project', function () {
    $project = Project::create(['name' => 'Delete Project', 'status' => 'Cancelled']);

    $this->delete(route('crm.projects.destroy', $project))
        ->assertRedirect(route('crm.projects.index'));

    $this->assertSoftDeleted('crm_projects', ['id' => $project->id]);
});
