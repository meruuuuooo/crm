<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Contact;
use App\Models\Crm\Company;
use App\Models\Crm\Deal;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::with('company', 'owner')->latest()->paginate(15);
        return view('modules.crm.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users     = User::orderBy('name')->get();
        $companies = Company::orderBy('company_name')->get();
        $deals     = Deal::orderBy('deal_name')->get();
        return view('modules.crm.contacts.create', compact('users', 'companies', 'deals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'job_title'     => 'nullable|string|max:255',
            'company_id'    => 'nullable|exists:crm_companies,id',
            'email'         => 'nullable|email|max:255',
            'email_opt_out' => 'boolean',
            'phone_1'       => 'nullable|string|max:50',
            'phone_2'       => 'nullable|string|max:50',
            'fax'           => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
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

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('crm/contacts', 'public');
        }

        $data['email_opt_out'] = $request->boolean('email_opt_out');

        Contact::create($data);

        return redirect()->route('crm.contacts.index')->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load('company', 'owner', 'deals');
        return view('modules.crm.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $users     = User::orderBy('name')->get();
        $companies = Company::orderBy('company_name')->get();
        $deals     = Deal::orderBy('deal_name')->get();
        return view('modules.crm.contacts.edit', compact('contact', 'users', 'companies', 'deals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'job_title'     => 'nullable|string|max:255',
            'company_id'    => 'nullable|exists:crm_companies,id',
            'email'         => 'nullable|email|max:255',
            'email_opt_out' => 'boolean',
            'phone_1'       => 'nullable|string|max:50',
            'phone_2'       => 'nullable|string|max:50',
            'fax'           => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date',
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

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('crm/contacts', 'public');
        }

        $data['email_opt_out'] = $request->boolean('email_opt_out');

        $contact->update($data);

        return redirect()->route('crm.contacts.index')->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('crm.contacts.index')->with('success', 'Contact deleted.');
    }
}
