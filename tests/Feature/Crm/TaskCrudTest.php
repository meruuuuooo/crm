<?php

use App\Models\Crm\Task;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('can list tasks', function () {
    Task::create(['title' => 'Fix the bug', 'status' => 'Todo']);

    $this->get(route('crm.tasks.index'))
        ->assertOk()
        ->assertSee('Fix the bug');
});

it('can show the create task form', function () {
    $this->get(route('crm.tasks.create'))->assertOk();
});

it('can create a task', function () {
    $this->post(route('crm.tasks.store'), [
        'title'    => 'Write tests',
        'priority' => 'High',
        'status'   => 'Todo',
        'category' => 'Development',
    ])->assertRedirect(route('crm.tasks.index'));

    $this->assertDatabaseHas('crm_tasks', ['title' => 'Write tests']);
});

it('requires title to create a task', function () {
    $this->post(route('crm.tasks.store'), [
        'status' => 'Todo',
    ])->assertSessionHasErrors('title');
});

it('can show a task', function () {
    $task = Task::create(['title' => 'Show Task', 'status' => 'Todo']);

    $this->get(route('crm.tasks.show', $task))
        ->assertOk()
        ->assertSee('Show Task');
});

it('can show the edit task form', function () {
    $task = Task::create(['title' => 'Edit Task', 'status' => 'In Progress']);

    $this->get(route('crm.tasks.edit', $task))
        ->assertOk()
        ->assertSee('Edit Task');
});

it('can update a task', function () {
    $task = Task::create(['title' => 'Old Task', 'status' => 'Todo']);

    $this->put(route('crm.tasks.update', $task), [
        'title'  => 'Updated Task',
        'status' => 'Completed',
    ])->assertRedirect(route('crm.tasks.index'));

    $this->assertDatabaseHas('crm_tasks', ['id' => $task->id, 'title' => 'Updated Task', 'status' => 'Completed']);
});

it('can delete a task', function () {
    $task = Task::create(['title' => 'Delete Task', 'status' => 'Todo']);

    $this->delete(route('crm.tasks.destroy', $task))
        ->assertRedirect(route('crm.tasks.index'));

    $this->assertSoftDeleted('crm_tasks', ['id' => $task->id]);
});
