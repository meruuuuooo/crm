<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Proposal;
use App\Models\Crm\Contact;
use App\Models\Crm\Project;
use App\Models\Crm\Deal;
use App\Models\User;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proposals = Proposal::with('client', 'project', 'deal')->latest()->paginate(15);
        return view('modules.crm.proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('first_name')->get();
        $projects = Project::orderBy('name')->get();
        $deals    = Deal::orderBy('deal_name')->get();
        $users    = User::orderBy('name')->get();
        return view('modules.crm.proposals.create', compact('contacts', 'projects', 'deals', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'date'       => 'nullable|date',
            'open_till'  => 'nullable|date',
            'client_id'  => 'nullable|exists:crm_contacts,id',
            'project_id' => 'nullable|exists:crm_projects,id',
            'related_to' => 'nullable|string|max:100',
            'deal_id'    => 'nullable|exists:crm_deals,id',
            'currency'   => 'nullable|string|max:10',
            'status'     => 'nullable|string|max:100',
            'tags'       => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'assignees'  => 'nullable|array',
            'assignees.*'=> 'exists:users,id',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/proposals', 'public');
        }

        $proposal = Proposal::create($data);
        $proposal->assignees()->sync($request->input('assignees', []));

        return redirect()->route('crm.proposals.index')->with('success', 'Proposal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proposal $proposal)
    {
        $proposal->load('client', 'project', 'deal', 'assignees');
        return view('modules.crm.proposals.show', compact('proposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proposal $proposal)
    {
        $contacts = Contact::orderBy('first_name')->get();
        $projects = Project::orderBy('name')->get();
        $deals    = Deal::orderBy('deal_name')->get();
        $users    = User::orderBy('name')->get();
        return view('modules.crm.proposals.edit', compact('proposal', 'contacts', 'projects', 'deals', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proposal $proposal)
    {
        $data = $request->validate([
            'subject'    => 'required|string|max:255',
            'date'       => 'nullable|date',
            'open_till'  => 'nullable|date',
            'client_id'  => 'nullable|exists:crm_contacts,id',
            'project_id' => 'nullable|exists:crm_projects,id',
            'related_to' => 'nullable|string|max:100',
            'deal_id'    => 'nullable|exists:crm_deals,id',
            'currency'   => 'nullable|string|max:10',
            'status'     => 'nullable|string|max:100',
            'tags'       => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'assignees'  => 'nullable|array',
            'assignees.*'=> 'exists:users,id',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/proposals', 'public');
        }

        $proposal->update($data);
        $proposal->assignees()->sync($request->input('assignees', []));

        return redirect()->route('crm.proposals.index')->with('success', 'Proposal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proposal $proposal)
    {
        $proposal->delete();
        return redirect()->route('crm.proposals.index')->with('success', 'Proposal deleted.');
    }
}
