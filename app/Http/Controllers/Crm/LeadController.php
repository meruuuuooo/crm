<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Lead;
use App\Models\Crm\Company;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leads = Lead::with('company', 'owners')->latest()->paginate(15);
        return view('modules.crm.leads.index', compact('leads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('company_name')->get();
        $users     = User::orderBy('name')->get();
        return view('modules.crm.leads.create', compact('companies', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_name'  => 'required|string|max:255',
            'lead_type'  => 'required|in:individual,company',
            'company_id' => 'nullable|exists:crm_companies,id',
            'value'      => 'nullable|numeric|min:0',
            'currency'   => 'nullable|string|max:10',
            'phone'      => 'nullable|string|max:50',
            'phone_type' => 'nullable|string|max:50',
            'source'     => 'nullable|string|max:100',
            'industry'   => 'nullable|string|max:100',
            'tags'       => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'visibility' => 'required|in:public,private,team',
            'owners'     => 'nullable|array',
            'owners.*'   => 'exists:users,id',
        ]);

        $lead = Lead::create($data);
        $lead->owners()->sync($request->input('owners', []));

        return redirect()->route('crm.leads.index')->with('success', 'Lead created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        $lead->load('company', 'owners');
        return view('modules.crm.leads.show', compact('lead'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $companies = Company::orderBy('company_name')->get();
        $users     = User::orderBy('name')->get();
        return view('modules.crm.leads.edit', compact('lead', 'companies', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'lead_name'  => 'required|string|max:255',
            'lead_type'  => 'required|in:individual,company',
            'company_id' => 'nullable|exists:crm_companies,id',
            'value'      => 'nullable|numeric|min:0',
            'currency'   => 'nullable|string|max:10',
            'phone'      => 'nullable|string|max:50',
            'phone_type' => 'nullable|string|max:50',
            'source'     => 'nullable|string|max:100',
            'industry'   => 'nullable|string|max:100',
            'tags'       => 'nullable|string|max:255',
            'description'=> 'nullable|string',
            'visibility' => 'required|in:public,private,team',
            'owners'     => 'nullable|array',
            'owners.*'   => 'exists:users,id',
        ]);

        $lead->update($data);
        $lead->owners()->sync($request->input('owners', []));

        return redirect()->route('crm.leads.index')->with('success', 'Lead updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('crm.leads.index')->with('success', 'Lead deleted.');
    }
}
