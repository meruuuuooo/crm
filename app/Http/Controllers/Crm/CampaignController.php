<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(15);
        return view('modules.crm.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules.crm.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'campaign_type'   => 'nullable|string|max:100',
            'deal_value'      => 'nullable|numeric|min:0',
            'currency'        => 'nullable|string|max:10',
            'period'          => 'nullable|string|max:50',
            'period_value'    => 'nullable|numeric|min:0',
            'target_audience' => 'nullable|string|max:255',
            'description'     => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/campaigns', 'public');
        }

        Campaign::create($data);

        return redirect()->route('crm.campaigns.index')->with('success', 'Campaign created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return view('modules.crm.campaigns.show', compact('campaign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        return view('modules.crm.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'campaign_type'   => 'nullable|string|max:100',
            'deal_value'      => 'nullable|numeric|min:0',
            'currency'        => 'nullable|string|max:10',
            'period'          => 'nullable|string|max:50',
            'period_value'    => 'nullable|numeric|min:0',
            'target_audience' => 'nullable|string|max:255',
            'description'     => 'nullable|string',
        ]);

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('crm/campaigns', 'public');
        }

        $campaign->update($data);

        return redirect()->route('crm.campaigns.index')->with('success', 'Campaign updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('crm.campaigns.index')->with('success', 'Campaign deleted.');
    }
}
