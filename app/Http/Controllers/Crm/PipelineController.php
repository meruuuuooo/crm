<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\Models\Crm\Pipeline;
use App\Models\User;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pipelines = Pipeline::withCount('deals')->latest()->paginate(15);
        return view('modules.crm.pipelines.index', compact('pipelines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('modules.crm.pipelines.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'access_type'      => 'required|in:public,private',
            'stages'           => 'nullable|array',
            'stages.*'         => 'string|max:100',
            'selected_persons' => 'nullable|array',
        ]);

        Pipeline::create($data);

        return redirect()->route('crm.pipelines.index')->with('success', 'Pipeline created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pipeline $pipeline)
    {
        $pipeline->load('deals');
        return view('modules.crm.pipelines.show', compact('pipeline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pipeline $pipeline)
    {
        $users = User::orderBy('name')->get();
        return view('modules.crm.pipelines.edit', compact('pipeline', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pipeline $pipeline)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'access_type'      => 'required|in:public,private',
            'stages'           => 'nullable|array',
            'stages.*'         => 'string|max:100',
            'selected_persons' => 'nullable|array',
        ]);

        $pipeline->update($data);

        return redirect()->route('crm.pipelines.index')->with('success', 'Pipeline updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pipeline $pipeline)
    {
        $pipeline->delete();
        return redirect()->route('crm.pipelines.index')->with('success', 'Pipeline deleted.');
    }
}
