<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Activity;
use App\Models\Crm\Deal;
use App\Models\Crm\Contact;
use App\Models\Crm\Company;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activities = Activity::with('owner', 'deal', 'contact', 'company')->latest()->paginate(15);
        return view('modules.crm.activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users     = User::orderBy('name')->get();
        $deals     = Deal::orderBy('deal_name')->get();
        $contacts  = Contact::orderBy('first_name')->get();
        $companies = Company::orderBy('company_name')->get();
        return view('modules.crm.activities.create', compact('users', 'deals', 'contacts', 'companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'activity_type'  => 'nullable|string|max:50',
            'due_date'       => 'nullable|date',
            'time'           => 'nullable|date_format:H:i',
            'reminder_value' => 'nullable|integer|min:1',
            'reminder_unit'  => 'nullable|in:Minutes,Hours',
            'owner_id'       => 'nullable|exists:users,id',
            'description'    => 'nullable|string',
            'deal_id'        => 'nullable|exists:crm_deals,id',
            'contact_id'     => 'nullable|exists:crm_contacts,id',
            'company_id'     => 'nullable|exists:crm_companies,id',
            'guests'         => 'nullable|array',
            'guests.*'       => 'exists:users,id',
        ]);

        $activity = Activity::create($data);
        $activity->guests()->sync($request->input('guests', []));

        return redirect()->route('crm.activities.index')->with('success', 'Activity created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $activity->load('owner', 'guests', 'deal', 'contact', 'company');
        return view('modules.crm.activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        $users     = User::orderBy('name')->get();
        $deals     = Deal::orderBy('deal_name')->get();
        $contacts  = Contact::orderBy('first_name')->get();
        $companies = Company::orderBy('company_name')->get();
        return view('modules.crm.activities.edit', compact('activity', 'users', 'deals', 'contacts', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Activity $activity)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'activity_type'  => 'nullable|string|max:50',
            'due_date'       => 'nullable|date',
            'time'           => 'nullable|date_format:H:i',
            'reminder_value' => 'nullable|integer|min:1',
            'reminder_unit'  => 'nullable|in:Minutes,Hours',
            'owner_id'       => 'nullable|exists:users,id',
            'description'    => 'nullable|string',
            'deal_id'        => 'nullable|exists:crm_deals,id',
            'contact_id'     => 'nullable|exists:crm_contacts,id',
            'company_id'     => 'nullable|exists:crm_companies,id',
            'guests'         => 'nullable|array',
            'guests.*'       => 'exists:users,id',
        ]);

        $activity->update($data);
        $activity->guests()->sync($request->input('guests', []));

        return redirect()->route('crm.activities.index')->with('success', 'Activity updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('crm.activities.index')->with('success', 'Activity deleted.');
    }
}
