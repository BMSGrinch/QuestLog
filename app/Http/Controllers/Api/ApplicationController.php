<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Services\ApplicationsService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    protected $applicationsService;
    public function __construct(ApplicationsService $applicationsService){
        $this->applicationsService = $applicationsService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $application = Application::latest()->paginate(10);
        return response()->json(['data'=>$application]);
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
            'status' => 'required|string|in:applied,screening,interview,rejected,accepted',
            'applied_at' => 'required|date',
            'notes'=> 'nullable|string',
        ]);
        $application = $this->applicationsService->createApplication(auth()->id(),$validated);

        return response()->json(['data'=>$application] , 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Application $application)
    {
        //
        if($application->candidate_id !==auth()->id()){
            return response()->json(['message'=>'Accès non autorisé'] , 403);
        }
        $application->load('jobOffer', 'applicationStatusHistories');
    return response()->json(['data' => $application]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
        //
        
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
            return response()->json(['message'=>'Accès non autorisé',403] );
        }
        $this->applicationsService->updateApplication($application , $validated , auth()->id());
        
        return response()->json(['data'=>$application] , 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
    {
        //
        if($application->candidate_id !==auth()->id()){
           return response()->json(['message'=>'Accès non autorisé',403] );
        }
        $application->delete();
        return response()->json(['data'=>$application] , 200);
    }
}
