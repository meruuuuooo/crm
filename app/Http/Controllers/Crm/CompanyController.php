<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::with('owner')->latest()->paginate(15);
        return view('modules.crm.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('modules.crm.companies.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name'  => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'email_opt_out' => 'boolean',
            'phone_1'       => 'nullable|string|max:50',
            'phone_2'       => 'nullable|string|max:50',
            'fax'           => 'nullable|string|max:50',
            'website'       => 'nullable|url|max:255',
            'reviews'       => 'nullable|string|max:255',
            'owner_id'      => 'nullable|exists:users,id',
            'tags'          => 'nullable|string|max:255',
            'source'        => 'nullable|string|max:100',
            'industry'      => 'nullable|string|max:100',
            'currency'      => 'nullable|string|max:10',
            'language'      => 'nullable|string|max:50',
            'description'   => 'nullable|string',
            'street_address'=> 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'zipcode'       => 'nullable|string|max:20',
            'facebook'      => 'nullable|string|max:255',
            'skype'         => 'nullable|string|max:255',
            'linkedin'      => 'nullable|string|max:255',
            'twitter'       => 'nullable|string|max:255',
            'whatsapp'      => 'nullable|string|max:255',
            'instagram'     => 'nullable|string|max:255',
            'visibility'    => 'required|in:public,private,team',
        ]);

        if ($request->hasFile('company_files')) {
            $data['company_files'] = $request->file('company_files')->store('crm/companies', 'public');
        }

        $data['email_opt_out'] = $request->boolean('email_opt_out');

        Company::create($data);

        return redirect()->route('crm.companies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        $company->load('owner', 'contacts', 'leads');
        return view('modules.crm.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        $users = User::orderBy('name')->get();
        return view('modules.crm.companies.edit', compact('company', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'company_name'  => 'required|string|max:255',
            'email'         => 'nullable|email|max:255',
            'email_opt_out' => 'boolean',
            'phone_1'       => 'nullable|string|max:50',
            'phone_2'       => 'nullable|string|max:50',
            'fax'           => 'nullable|string|max:50',
            'website'       => 'nullable|url|max:255',
            'reviews'       => 'nullable|string|max:255',
            'owner_id'      => 'nullable|exists:users,id',
            'tags'          => 'nullable|string|max:255',
            'source'        => 'nullable|string|max:100',
            'industry'      => 'nullable|string|max:100',
            'currency'      => 'nullable|string|max:10',
            'language'      => 'nullable|string|max:50',
            'description'   => 'nullable|string',
            'street_address'=> 'nullable|string|max:255',
            'country'       => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'zipcode'       => 'nullable|string|max:20',
            'facebook'      => 'nullable|string|max:255',
            'skype'         => 'nullable|string|max:255',
            'linkedin'      => 'nullable|string|max:255',
            'twitter'       => 'nullable|string|max:255',
            'whatsapp'      => 'nullable|string|max:255',
            'instagram'     => 'nullable|string|max:255',
            'visibility'    => 'required|in:public,private,team',
        ]);

        if ($request->hasFile('company_files')) {
            $data['company_files'] = $request->file('company_files')->store('crm/companies', 'public');
        }

        $data['email_opt_out'] = $request->boolean('email_opt_out');

        $company->update($data);

        return redirect()->route('crm.companies.index')->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('crm.companies.index')->with('success', 'Company deleted.');
    }
}
