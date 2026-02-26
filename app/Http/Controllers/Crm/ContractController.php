<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Contract;
use App\Models\Crm\Contact;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::with('client')->latest()->paginate(15);
        return view('modules.crm.contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('first_name')->get();
        return view('modules.crm.contracts.create', compact('contacts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject'        => 'required|string|max:255',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date',
            'client_id'      => 'nullable|exists:crm_contacts,id',
            'contract_type'  => 'nullable|string|max:100',
            'contract_value' => 'nullable|numeric|min:0',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/contracts', 'public');
        }

        Contract::create($data);

        return redirect()->route('crm.contracts.index')->with('success', 'Contract created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contract $contract)
    {
        $contract->load('client');
        return view('modules.crm.contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $contacts = Contact::orderBy('first_name')->get();
        return view('modules.crm.contracts.edit', compact('contract', 'contacts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $data = $request->validate([
            'subject'        => 'required|string|max:255',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date',
            'client_id'      => 'nullable|exists:crm_contacts,id',
            'contract_type'  => 'nullable|string|max:100',
            'contract_value' => 'nullable|numeric|min:0',
            'description'    => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/contracts', 'public');
        }

        $contract->update($data);

        return redirect()->route('crm.contracts.index')->with('success', 'Contract updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('crm.contracts.index')->with('success', 'Contract deleted.');
    }
}
