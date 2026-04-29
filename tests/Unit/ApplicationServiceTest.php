<?php

namespace Tests\Unit;

use App\Models\JobOffer;
use App\Models\User;
use App\Services\ApplicationsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplicationServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_creer_une_candidature_avec_des_donnees_valide()
    {

        // ARRANGE
        $recruiter = User::factory()->create(['role'=>'recruiter']);
        $jobOffer = JobOffer::factory()->create(['recruiter_id'=>$recruiter->id]);
        $candidate = User::factory()->create(['role'=>'candidate']);
        $data = [
            'job_offer_id' => $jobOffer->id,
            'company_name' => 'Acme CI',
            'position' => 'Développeur Full Stack',
            'status' => 'applied',
            'applied_at' => '2026-03-15 ',
        ];

        // ACT
        $service = new ApplicationsService();
        $application = $service->createApplication($candidate->id , $data);

        // ASSERT
        $this->assertNotNull($application);
        $this->assertEquals('Développeur Full Stack',$application->position);
        $this->assertEquals($candidate->id , $application->candidate_id);
        $this->assertDatabaseHas('applications',['position'=>'Développeur Full Stack' , 'candidate_id'=>$candidate->id]);
    }
}
    