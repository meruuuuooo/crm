<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Invoice;
use App\Models\Crm\Contact;
use App\Models\Crm\Project;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('client', 'project')->latest()->paginate(15);
        return view('modules.crm.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contacts = Contact::orderBy('first_name')->get();
        $projects = Project::orderBy('name')->get();
        return view('modules.crm.invoices.create', compact('contacts', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'      => 'nullable|exists:crm_contacts,id',
            'bill_to'        => 'nullable|string',
            'ship_to'        => 'nullable|string',
            'project_id'     => 'nullable|exists:crm_projects,id',
            'amount'         => 'nullable|numeric|min:0',
            'currency'       => 'nullable|string|max:10',
            'date'           => 'nullable|date',
            'open_till'      => 'nullable|date',
            'payment_method' => 'nullable|string|max:100',
            'status'         => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'notes'          => 'nullable|string',
            'terms_conditions'=> 'nullable|string',
            'line_items'     => 'nullable|array',
        ]);

        $data['line_items'] = $request->input('line_items', []);

        Invoice::create($data);

        return redirect()->route('crm.invoices.index')->with('success', 'Invoice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('client', 'project');
        return view('modules.crm.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        $contacts = Contact::orderBy('first_name')->get();
        $projects = Project::orderBy('name')->get();
        return view('modules.crm.invoices.edit', compact('invoice', 'contacts', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'client_id'      => 'nullable|exists:crm_contacts,id',
            'bill_to'        => 'nullable|string',
            'ship_to'        => 'nullable|string',
            'project_id'     => 'nullable|exists:crm_projects,id',
            'amount'         => 'nullable|numeric|min:0',
            'currency'       => 'nullable|string|max:10',
            'date'           => 'nullable|date',
            'open_till'      => 'nullable|date',
            'payment_method' => 'nullable|string|max:100',
            'status'         => 'nullable|string|max:100',
            'description'    => 'nullable|string',
            'notes'          => 'nullable|string',
            'terms_conditions'=> 'nullable|string',
            'line_items'     => 'nullable|array',
        ]);

        $data['line_items'] = $request->input('line_items', []);

        $invoice->update($data);

        return redirect()->route('crm.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('crm.invoices.index')->with('success', 'Invoice deleted.');
    }
}
