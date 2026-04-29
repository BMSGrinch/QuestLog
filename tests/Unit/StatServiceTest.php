<?php

namespace Tests\Unit;

use App\Models\Application;
use App\Models\JobOffer;
use App\Models\User;
use App\Services\StatsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase ; 

class StatServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */

    // BON Là Les tests ne fonctionnent pas car il y a un souci sur la bdd de test. La bd de test utilise sqlite mais moi j'utilise mysql qui est plus lourd et qui prend en compte les datediff donc je bouais les tests sur les stats pour le moment.
    
    
    public function test_get_candidate_stats(){
        //ARRANGE

        $candidate = User::factory()->create(['role'=>'candidate']);
            Application::factory()->count(5)->create([
                'candidate_id'=>$candidate->id , 
                'status'=>'interview'
            ]);

            Application::factory()->count(5)->create([
                'candidate_id'=>$candidate->id , 
                'status'=>'applied'
            ]);

        //ACt

        $service = new StatsService();
        $candidateStats = $service->getCandidateStats($candidate->id);

        //ASSERT

        $this->assertEquals(50 , $candidateStats['tauxSuccessApplication']);
    }

    public function test_get_recruiter_stats(){
        //ARRANGE

        $recruiter = User::factory()->create(['role'=>'recruiter']);
        $offers = JobOffer::factory()->count(10)->create(
            ['recruiter_id'=>$recruiter->id]
        );

        //ACt

        $service = new StatsService();
        $recruiterStats = $service->getRecruiterStats($recruiter->id);

        //ASSERT

        $this->assertEquals(10 , $recruiterStats['totalJobOffer']);
        }

        
    }
