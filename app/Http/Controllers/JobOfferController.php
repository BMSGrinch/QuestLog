<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $jobOffers = JobOffer::latest()->paginate(10);
        return view('job-offers.index', compact('jobOffers'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('job-offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'contract_type' => 'required|string|in:CDI,CDD,Stage,Freelance',
            'salary' => 'nullable|string|max:25',
            'experience_min' => 'required|integer|min:0',
            'experience_max' => 'nullable|integer|min:0',
            'skills_required' => 'required|string',
            'application_deadline' => 'nullable|date',
            'remote_policy' => 'nullable|string|in:onsite,remote,hybrid',
            'status' => 'required|string|in:draft,open,closed',
        ]);

        JobOffer::create([
            ...$validated, 'recruiter_id' => auth()->id(),
        ]);
        return redirect()->route('job-offers.index')->with('success', 'offre créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, JobOffer $jobOffer)
    {
        //
        $jobOffer->jobOfferViews()->create([
            'ip_address' => $request->ip(),
        ]);

        return view('job-offers.info', compact('jobOffer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $jobOffer)
    {
        //
        return view('job-offers.edit', compact('jobOffer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        //
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'contract_type' => 'required|string|in:CDI,CDD,Stage,Freelance',
            'salary' => 'nullable|string|max:25',
            'experience_min' => 'required|integer|min:0',
            'experience_max' => 'nullable|integer|min:0',
            'skills_required' => 'required|string',
            'application_deadline' => 'nullable|date',
            'remote_policy' => 'nullable|string|in:onsite,remote,hybrid',
            'status' => 'required|string|in:draft,open,closed',
        ]);

        $jobOffer->update($validated);
        return redirect()->route('job-offers.index')->with('success', 'offre mise à jour avec succès.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $jobOffer)
    {
        //
        $jobOffer->delete();
        return redirect()->route('job-offers.index')->with('success', 'offre supprimée avec succès.');
    }
}
