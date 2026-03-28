<?php

namespace App\Services;

use App\Models\Application;
use App\Models\ApplicationStatusHistory;
use App\Models\JobOffer;
use App\Models\JobOfferView;
use Illuminate\Support\Facades\DB;

class StatsService {
    //

    /*
    ** Coté Candidat 
    */

    public function getCandidateStats(int $userId):array{
         //Nombre total de candidatures
        $totalApplication = Application::where('candidate_id', $userId)->count();

        //nombre par statut 
        $statusApplication = Application::select('status',DB::raw('count(*)as total'))->where('candidate_id',$userId)->groupBy('status')->get();

        //taux de réponse candidature
        $tauxApplication = 0 ;
        $responseApplication = Application::whereIn('status',['interview','rejected','accepted'])->where('candidate_id',$userId)->count();
        if($totalApplication>0){
            $tauxApplication = ($responseApplication/$totalApplication)*100 ;
        }

        //taux de conversion/entretien
        $tauxSuccessApplication = 0 ;
        $successApplication = Application::whereIn('status',['interview','accepted'])->where('candidate_id',$userId)->count();
        if($totalApplication>0){
            $tauxSuccessApplication=($successApplication/$totalApplication)*100;
        }

        //temps moyen entre envoie et 1ere réponse 
        $tempsReponseMoyenne = ApplicationStatusHistory::whereIn('new_status',['interview','rejected','accepted'])->join('applications','application_status_histories.application_id','=','applications.id')->where('applications.candidate_id',$userId)->selectRaw('AVG(DATEDIFF(application_status_histories.changed_at, applications.applied_at)) as moyenne_jours')->first();

        //candidature mois 
        $mouthApplication = Application::selectRaw('MONTH(created_at) as mois , count(*) as total')->whereYear('created_at',date('Y'))->where('candidate_id', $userId)->groupBy('mois')->orderBy('mois')->get();

        //répartitipon par type de contrat 
        $statContrat = Application::join('job_offers','applications.job_offer_id','=','job_offers.id')->select('job_offers.contract_type',DB::raw('count(*) as total'))->where('applications.candidate_id',$userId)->groupBy('job_offers.contract_type')->get();

        //top 5 des entreprises les plus contactées 
        $topCompany = Application::select('company_name', DB::raw('count(*) as total_candidatures'))->where('candidate_id' , $userId)->groupBy('company_name')->orderByDesc('total_candidatures')->limit(5)->get();
    
        return [
            'totalApplication'=>$totalApplication,
            'statusApplication'=>$statusApplication,
            'tauxApplication'=> $tauxApplication,
            'tauxSuccessApplication'=> $tauxSuccessApplication,
            'tempsReponseMoyenne' =>$tempsReponseMoyenne,
            'mouthApplication'=> $mouthApplication,
            'statContrat'=>$statContrat,
            'topCompany'=>$topCompany,
            ];
    }

     /*
    ** Coté Recruteur 
    */

    public function getRecruiterStats(int $userId):array{
            //Nombre total d'offres publiées
         $totalJobOffer = JobOffer::where('recruiter_id',$userId)->count();

        //nombred'offres actives/closes
        $statusJobOffer = JobOffer::select('status',DB::raw('count(*)as total'))->where('recruiter_id',$userId)->groupBy('status')->get();

        //total candidatures recues sur toutes les offres 
        $totalApplicationOffer = JobOffer::join('applications','job_offers.id', '=', 'applications.job_offer_id') ->select('job_offers.title',DB::raw('count(applications.id) as total_candidatures'))->where('recruiter_id' , $userId)->groupBy('job_offers.title', 'job_offers.id')->get();

        //taux de conversion/offre
        $tauxConversion = JobOffer::where('recruiter_id', $userId)->withCount(['applications', 'jobOfferViews'])->get()->map(function($offer){
            $offer->tauxConversion = 0 ;
            if($offer->job_offer_views_count>0){
                $offer->tauxConversion = ($offer->applications_count / $offer->job_offer_views_count)*100 ;
            }
            return $offer ;
        });
        
        //nombre de vues sur les offres 
        $viewsOffer = JobOfferView::join('job_offers','job_offer_views.job_offer_id', '=' , 'job_offers.id')->where('job_offers.recruiter_id', $userId)->count();

        //candidats/statut offre
        $statCandidats = Application::join('job_offers', 'applications.job_offer_id', '=' , 'job_offers.id')->where('recruiter_id' , $userId)->select('job_offers.title','applications.status',DB::raw('count(*) as total'))->groupBy('job_offers.id','job_offers.title','applications.status')->get();

        //offre les plus vues 
         $topoffers = JobOfferView::join('job_offers' , 'job_offer_views.job_offer_id' , '=' , 'job_offers.id')->select('job_offer_id', DB::raw('count(*) as popular_offers'))->where('recruiter_id' , $userId)->groupBy('job_offers.id' , 'job_offers.title')->orderByDesc('popular_offers')->limit(10)->get();

        //evolution des candidatures sur le mois
        $evolution = JobOffer::where('recruiter_id' , $userId)->selectRaw('MONTH(created_at) as mois, count(*) as total')->whereYear('created_at',date('Y'))->groupBy('mois')->orderBy('mois')->get();

        return
            [
                'totalJobOffer'=> $totalJobOffer,
                'statusJobOffer'=> $statusJobOffer,
                'totalApplicationOffer'=> $totalApplicationOffer,
                'tauxConversion'=> $tauxConversion,
                'viewsOffer'=> $viewsOffer,
                'statCandidats'=> $statCandidats,
                'topoffers'=> $topoffers,
                'evolution'=> $evolution
                ];
    }
}