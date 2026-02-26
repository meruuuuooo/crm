<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Estimation;
use App\Models\Crm\Contact;
use App\Models\Crm\Project;
use Illuminate\Http\Request;

class EstimationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estimations = Estimation::with('client', 'project')->latest()->paginate(15);
        return view('modules.crm.estimations.index', compact('estimations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('first_name')->get();
        $projects = Project::orderBy('name')->get();
        return view('modules.crm.estimations.create', compact('contacts', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'     => 'nullable|exists:crm_contacts,id',
            'bill_to'       => 'nullable|string',
            'ship_to'       => 'nullable|string',
            'project_id'    => 'nullable|exists:crm_projects,id',
            'estimate_by'   => 'nullable|string|max:100',
            'amount'        => 'nullable|numeric|min:0',
            'currency'      => 'nullable|string|max:10',
            'estimate_date' => 'nullable|date',
            'expiry_date'   => 'nullable|date',
            'status'        => 'nullable|string|max:100',
            'tags'          => 'nullable|string|max:255',
            'description'   => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/estimations', 'public');
        }

        Estimation::create($data);

        return redirect()->route('crm.estimations.index')->with('success', 'Estimation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Estimation $estimation)
    {
        $estimation->load('client', 'project');
        return view('modules.crm.estimations.show', compact('estimation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estimation $estimation)
    {
        $contacts = Contact::orderBy('first_name')->get();
        $projects = Project::orderBy('name')->get();
        return view('modules.crm.estimations.edit', compact('estimation', 'contacts', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Estimation $estimation)
    {
        $data = $request->validate([
            'client_id'     => 'nullable|exists:crm_contacts,id',
            'bill_to'       => 'nullable|string',
            'ship_to'       => 'nullable|string',
            'project_id'    => 'nullable|exists:crm_projects,id',
            'estimate_by'   => 'nullable|string|max:100',
            'amount'        => 'nullable|numeric|min:0',
            'currency'      => 'nullable|string|max:10',
            'estimate_date' => 'nullable|date',
            'expiry_date'   => 'nullable|date',
            'status'        => 'nullable|string|max:100',
            'tags'          => 'nullable|string|max:255',
            'description'   => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/estimations', 'public');
        }

        $estimation->update($data);

        return redirect()->route('crm.estimations.index')->with('success', 'Estimation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estimation $estimation)
    {
        $estimation->delete();
        return redirect()->route('crm.estimations.index')->with('success', 'Estimation deleted.');
    }
}
