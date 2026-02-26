<?php

use App\Models\Crm\Pipeline;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list pipelines', function () {
    Pipeline::create(['name' => 'Sales', 'access_type' => 'public', 'stages' => ['Lead', 'Won']]);

    $this->get(route('crm.pipelines.index'))
        ->assertOk()
        ->assertSee('Sales');
});

it('can show the create pipeline form', function () {
    $this->get(route('crm.pipelines.create'))->assertOk();
});

it('can create a pipeline', function () {
    $this->post(route('crm.pipelines.store'), [
        'name'        => 'New Pipeline',
        'access_type' => 'public',
        'stages'      => ['Lead', 'Qualified', 'Won'],
    ])->assertRedirect(route('crm.pipelines.index'));

    $this->assertDatabaseHas('crm_pipelines', ['name' => 'New Pipeline']);
});

it('requires name and access_type to create a pipeline', function () {
    $this->post(route('crm.pipelines.store'), [])
        ->assertSessionHasErrors(['name', 'access_type']);
});

it('can show a pipeline', function () {
    $pipeline = Pipeline::create(['name' => 'Show Pipeline', 'access_type' => 'public', 'stages' => []]);

    $this->get(route('crm.pipelines.show', $pipeline))
        ->assertOk()
        ->assertSee('Show Pipeline');
});

it('can show the edit pipeline form', function () {
    $pipeline = Pipeline::create(['name' => 'Edit Pipeline', 'access_type' => 'public', 'stages' => []]);

    $this->get(route('crm.pipelines.edit', $pipeline))
        ->assertOk()
        ->assertSee('Edit Pipeline');
});

it('can update a pipeline', function () {
    $pipeline = Pipeline::create(['name' => 'Old Pipeline', 'access_type' => 'public', 'stages' => []]);

    $this->put(route('crm.pipelines.update', $pipeline), [
        'name'        => 'Updated Pipeline',
        'access_type' => 'private',
    ])->assertRedirect(route('crm.pipelines.index'));

    $this->assertDatabaseHas('crm_pipelines', ['id' => $pipeline->id, 'name' => 'Updated Pipeline']);
});

it('can delete a pipeline', function () {
    $pipeline = Pipeline::create(['name' => 'Delete Pipeline', 'access_type' => 'public', 'stages' => []]);

    $this->delete(route('crm.pipelines.destroy', $pipeline))
        ->assertRedirect(route('crm.pipelines.index'));

    $this->assertSoftDeleted('crm_pipelines', ['id' => $pipeline->id]);
});
