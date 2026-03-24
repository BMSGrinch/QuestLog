<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $applications = Application::latest()->paginate(10);
        return view('applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('applications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'job_offer_id' => 'nullable|exists:job_offers,id',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'job_link' => 'nullable|url',
            'status' => 'required|string|in:applied,screening,interview, rejected,accepted',
            'applied_at' => 'required|date',
            'notes'=> 'nullable|string',
        ]);
        Application::create([
            ...$validated, 'candidate_id' => auth()->id(),
        ]);

        return redirect()->route('applications.index')->with('success', 'Candidature créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
        if($application->candidate_id !==auth()->id()){
            abort(403, 'Accès non autorisé');
        }
        $application->load('jobOffer','applicationStatusHistories');
        return view('applications.info', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application)
    {
        //
        if($application->candidate_id !==auth()->id()){
            abort(403, 'Accès non autorisé');
        }
        return view('applications.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        // 
        $oldStatus = $application->status;
        $validated = $request->validate([
            'job_offer_id' => 'nullable|exists:job_offers,id',
            'company_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'job_link' => 'nullable|url',
            'status' => 'required|string|in:applied,screening,interview,rejected,accepted',
            'applied_at' => 'required|date',
            'notes'=> 'nullable|string',
        ]);
         if($application->candidate_id !==auth()->id()){
            abort(403, 'Accès non autorisé');
        }
        $application->update($validated);

        if($oldStatus !==$validated['status']){
            $application->applicationStatusHistories()->create([
                'old_status'=>$oldStatus,
                'new_status'=>$validated['status'],
                'changed_by'=>auth()->id(),
                'changed_at'=>now(),
            ]);
        }
        
        return redirect()->route('applications.index')->with('success', 'Candidature mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
        if($application->candidate_id !==auth()->id()){
            abort(403, 'Accès non autorisé');
        }
        $application->delete();
        return redirect()->route('applications.index')->with('success', 'Candidature supprimée avec succès.');
    }
}
