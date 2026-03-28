<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StatsService;

class StatsController extends Controller
{
    //

    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

     /*
    ** Coté Candidat
    */    

    public function candidate(){
       $stats = $this->statsService->getCandidateStats(auth()->id());
        return response()->json([
            'data'=>$stats
            ]);
    }
       
    /*
    ** Coté Recruteur 
    */    

    public function recruiter(){
       $stats = $this->statsService->getRecruiterStats(auth()->id());
        return response()->json(
            [
                'data'=>$stats
                ]);
    }
        
    }

