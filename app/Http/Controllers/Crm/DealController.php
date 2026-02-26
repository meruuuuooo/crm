<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Deal;
use App\Models\Crm\Contact;
use App\Models\Crm\Pipeline;
use App\Models\User;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::with('pipeline', 'contacts', 'assignees')->latest()->paginate(15);
        return view('modules.crm.deals.index', compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pipelines = Pipeline::orderBy('name')->get();
        $contacts  = Contact::orderBy('first_name')->get();
        $users     = User::orderBy('name')->get();
        return view('modules.crm.deals.create', compact('pipelines', 'contacts', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'deal_name'             => 'required|string|max:255',
            'pipeline_id'           => 'nullable|exists:crm_pipelines,id',
            'status'                => 'nullable|string|max:100',
            'deal_value'            => 'nullable|numeric|min:0',
            'currency'              => 'nullable|string|max:10',
            'period'                => 'nullable|string|max:50',
            'period_value'          => 'nullable|numeric|min:0',
            'project'               => 'nullable|string|max:255',
            'due_date'              => 'nullable|date',
            'expected_closing_date' => 'nullable|date',
            'follow_up_date'        => 'nullable|date',
            'source'                => 'nullable|string|max:100',
            'tags'                  => 'nullable|string|max:255',
            'priority'              => 'nullable|string|max:50',
            'description'           => 'nullable|string',
            'contacts'              => 'nullable|array',
            'contacts.*'            => 'exists:crm_contacts,id',
            'assignees'             => 'nullable|array',
            'assignees.*'           => 'exists:users,id',
        ]);

        $deal = Deal::create($data);
        $deal->contacts()->sync($request->input('contacts', []));
        $deal->assignees()->sync($request->input('assignees', []));

        return redirect()->route('crm.deals.index')->with('success', 'Deal created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Deal $deal)
    {
        $deal->load('pipeline', 'contacts', 'assignees');
        return view('modules.crm.deals.show', compact('deal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deal $deal)
    {
        $pipelines = Pipeline::orderBy('name')->get();
        $contacts  = Contact::orderBy('first_name')->get();
        $users     = User::orderBy('name')->get();
        return view('modules.crm.deals.edit', compact('deal', 'pipelines', 'contacts', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Deal $deal)
    {
        $data = $request->validate([
            'deal_name'             => 'required|string|max:255',
            'pipeline_id'           => 'nullable|exists:crm_pipelines,id',
            'status'                => 'nullable|string|max:100',
            'deal_value'            => 'nullable|numeric|min:0',
            'currency'              => 'nullable|string|max:10',
            'period'                => 'nullable|string|max:50',
            'period_value'          => 'nullable|numeric|min:0',
            'project'               => 'nullable|string|max:255',
            'due_date'              => 'nullable|date',
            'expected_closing_date' => 'nullable|date',
            'follow_up_date'        => 'nullable|date',
            'source'                => 'nullable|string|max:100',
            'tags'                  => 'nullable|string|max:255',
            'priority'              => 'nullable|string|max:50',
            'description'           => 'nullable|string',
            'contacts'              => 'nullable|array',
            'contacts.*'            => 'exists:crm_contacts,id',
            'assignees'             => 'nullable|array',
            'assignees.*'           => 'exists:users,id',
        ]);

        $deal->update($data);
        $deal->contacts()->sync($request->input('contacts', []));
        $deal->assignees()->sync($request->input('assignees', []));

        return redirect()->route('crm.deals.index')->with('success', 'Deal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deal $deal)
    {
        $deal->delete();
        return redirect()->route('crm.deals.index')->with('success', 'Deal deleted.');
    }
}
