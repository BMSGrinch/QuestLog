<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Services\JobOfferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{

    protected $jobOffersService ; 
    public function __construct(JobOfferService $jobOffersService)
    {
        $this->jobOffersService = $jobOffersService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        //

       $jobOffer = JobOffer::latest()->paginate(10);
       return response()->json([
            'data'=> $jobOffer ,
            'message'=> 'Offres récupérées avec succès' 
       ],200);
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

        $jobOffer = $this->jobOffersService->createJobOffer(auth()->id() , $validated);
        return response()->json(['data' =>$jobOffer] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request , JobOffer $jobOffer)
    {
        //
        $jobOffer->jobOfferViews()->create([
            'ip_address'=>$request->ip(),
        ]);
        $jobOffer->load('recruiter','applications');
        return response()->json(['data'=>$jobOffer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        //
        if($jobOffer->recruiter_id !== auth()->id() ){
            return response()->json(['message'=>'Accès interdit'], 403);
        }
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

        $this->jobOffersService->updateJobOffer($validated , $jobOffer);
        return response()->json(['data'=>$jobOffer]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $jobOffer)
    {
        //
        if($jobOffer->recruiter_id !== auth()->id()){
            return response()->json(['message' =>'Accès interdit'] , 403);
        }
        $jobOffer->delete();
        return response()->json(['message'=>'Offre supprimée avec succès']);
    }
}
