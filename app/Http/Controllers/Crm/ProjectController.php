<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Project;
use App\Models\Crm\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('client', 'responsiblePersons')->latest()->paginate(15);
        return view('modules.crm.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('first_name')->get();
        $users    = User::orderBy('name')->get();
        return view('modules.crm.projects.create', compact('contacts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'project_id_code' => 'nullable|string|max:100',
            'project_type'    => 'nullable|string|max:100',
            'client_id'       => 'nullable|exists:crm_contacts,id',
            'category'        => 'nullable|string|max:100',
            'project_timing'  => 'nullable|string|max:100',
            'price'           => 'nullable|numeric|min:0',
            'start_date'      => 'nullable|date',
            'due_date'        => 'nullable|date',
            'priority'        => 'nullable|string|max:50',
            'status'          => 'nullable|string|max:100',
            'description'     => 'nullable|string',
            'responsible_persons' => 'nullable|array',
            'responsible_persons.*' => 'exists:users,id',
            'team_leaders'    => 'nullable|array',
            'team_leaders.*'  => 'exists:users,id',
        ]);

        $project = Project::create($data);
        $project->responsiblePersons()->sync($request->input('responsible_persons', []));
        $project->teamLeaders()->sync($request->input('team_leaders', []));

        return redirect()->route('crm.projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('client', 'responsiblePersons', 'teamLeaders');
        return view('modules.crm.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $contacts = Contact::orderBy('first_name')->get();
        $users    = User::orderBy('name')->get();
        return view('modules.crm.projects.edit', compact('project', 'contacts', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'project_id_code' => 'nullable|string|max:100',
            'project_type'    => 'nullable|string|max:100',
            'client_id'       => 'nullable|exists:crm_contacts,id',
            'category'        => 'nullable|string|max:100',
            'project_timing'  => 'nullable|string|max:100',
            'price'           => 'nullable|numeric|min:0',
            'start_date'      => 'nullable|date',
            'due_date'        => 'nullable|date',
            'priority'        => 'nullable|string|max:50',
            'status'          => 'nullable|string|max:100',
            'description'     => 'nullable|string',
            'responsible_persons' => 'nullable|array',
            'responsible_persons.*' => 'exists:users,id',
            'team_leaders'    => 'nullable|array',
            'team_leaders.*'  => 'exists:users,id',
        ]);

        $project->update($data);
        $project->responsiblePersons()->sync($request->input('responsible_persons', []));
        $project->teamLeaders()->sync($request->input('team_leaders', []));

        return redirect()->route('crm.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('crm.projects.index')->with('success', 'Project deleted.');
    }
}
