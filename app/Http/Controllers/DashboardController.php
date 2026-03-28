<?php

namespace App\Http\Controllers;


use App\Services\StatsService;

class DashboardController extends Controller
{
    // Un peu de stat ça fait plaisir mdr

    
    protected $statsService ;
    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService ; 
    } 

    public function index(){

    /*
    ** Coté Candidat
    */    
      $candidateStats = $this->statsService->getCandidateStats(auth()->id());
    /*
    ** Coté Recruteur 
    */    
      $recruiterStats = $this->statsService->getRecruiterStats(auth()->id());

     return view('dashboard', array_merge($candidateStats , $recruiterStats));   
    }
}
