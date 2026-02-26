<?php

use App\Models\Crm\Activity;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list activities', function () {
    Activity::create(['title' => 'Call John', 'activity_type' => 'Call', 'owner_id' => $this->user->id]);

    $this->get(route('crm.activities.index'))
        ->assertOk()
        ->assertSee('Call John');
});

it('can show the create activity form', function () {
    $this->get(route('crm.activities.create'))->assertOk();
});

it('can create an activity', function () {
    $this->post(route('crm.activities.store'), [
        'title'         => 'Follow Up Call',
        'activity_type' => 'Call',
        'due_date'      => '2026-03-01',
        'time'          => '10:00',
        'owner_id'      => $this->user->id,
    ])->assertRedirect(route('crm.activities.index'));

    $this->assertDatabaseHas('crm_activities', ['title' => 'Follow Up Call']);
});

it('requires title to create an activity', function () {
    $this->post(route('crm.activities.store'), [
        'activity_type' => 'Call',
    ])->assertSessionHasErrors('title');
});

it('can show an activity', function () {
    $activity = Activity::create(['title' => 'Show Activity', 'activity_type' => 'Meeting', 'owner_id' => $this->user->id]);

    $this->get(route('crm.activities.show', $activity))
        ->assertOk()
        ->assertSee('Show Activity');
});

it('can show the edit activity form', function () {
    $activity = Activity::create(['title' => 'Edit Activity', 'activity_type' => 'Email', 'owner_id' => $this->user->id]);

    $this->get(route('crm.activities.edit', $activity))
        ->assertOk()
        ->assertSee('Edit Activity');
});

it('can update an activity', function () {
    $activity = Activity::create(['title' => 'Old Activity', 'activity_type' => 'Call', 'owner_id' => $this->user->id]);

    $this->put(route('crm.activities.update', $activity), [
        'title'         => 'Updated Activity',
        'activity_type' => 'Demo',
        'owner_id'      => $this->user->id,
    ])->assertRedirect(route('crm.activities.index'));

    $this->assertDatabaseHas('crm_activities', ['id' => $activity->id, 'title' => 'Updated Activity', 'activity_type' => 'Demo']);
});

it('can delete an activity', function () {
    $activity = Activity::create(['title' => 'Delete Activity', 'activity_type' => 'Task', 'owner_id' => $this->user->id]);

    $this->delete(route('crm.activities.destroy', $activity))
        ->assertRedirect(route('crm.activities.index'));

    $this->assertSoftDeleted('crm_activities', ['id' => $activity->id]);
});
