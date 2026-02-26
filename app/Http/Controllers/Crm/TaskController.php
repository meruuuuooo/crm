<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('responsiblePersons')->latest()->paginate(15);
        return view('modules.crm.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('modules.crm.tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'start_date'  => 'nullable|date',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|string|max:255',
            'priority'    => 'nullable|string|max:50',
            'status'      => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'responsible_persons'   => 'nullable|array',
            'responsible_persons.*' => 'exists:users,id',
        ]);

        $task = Task::create($data);
        $task->responsiblePersons()->sync($request->input('responsible_persons', []));

        return redirect()->route('crm.tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load('responsiblePersons');
        return view('modules.crm.tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::orderBy('name')->get();
        return view('modules.crm.tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:100',
            'start_date'  => 'nullable|date',
            'due_date'    => 'nullable|date',
            'tags'        => 'nullable|string|max:255',
            'priority'    => 'nullable|string|max:50',
            'status'      => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'responsible_persons'   => 'nullable|array',
            'responsible_persons.*' => 'exists:users,id',
        ]);

        $task->update($data);
        $task->responsiblePersons()->sync($request->input('responsible_persons', []));

        return redirect()->route('crm.tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('crm.tasks.index')->with('success', 'Task deleted.');
    }
}
