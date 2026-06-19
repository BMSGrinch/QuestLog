<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use Tests\TestCase;

class ApplicationApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_creer_une_candidature_par_api(): void
    {
        //ARRANGE
            $recruiter =User::factory()->create(['role'=>'recruiter']);
            $jobOffer =JobOffer::factory()->create(['recruiter_id'=>$recruiter->id]);
            $candidate = User::factory()->create(['role'=>'candidate']);
            $data = [
            'job_offer_id' => $jobOffer->id,
            'company_name' => 'Acme CI',
            'position' => 'Développeur Full Stack',
            'status' => 'applied',
            'applied_at' => '2026-03-15',
        ];

        //ACT
        $response = $this->actingAs($candidate)->postJson('/api/applications',$data);//On vérifie si le candidat est bien co et on récup les données

        //ASSERT
        $response->assertStatus(201)->assertJsonPath('data.position' , 'Développeur Full Stack');
        $this->assertDatabaseHas('applications', ['position'=>'Développeur Full Stack' , 'candidate_id'=>$candidate->id]);
    }

    public function test_un_candidat_ne_peut_pas_voir_la_candidature_dun_autre(){
        $candidate1 = User::factory()->create(['role' => 'candidate']);
        $candidate2 = User::factory()->create(['role' => 'candidate']);
        $jobOffer = JobOffer::factory()->create();
    
        // candidate1 crée une candidature
        $application = \App\Models\Application::factory()->create([
        'candidate_id' => $candidate1->id,
        'job_offer_id' => $jobOffer->id,
    ]);

    // candidate2 essaie de la voir
    $response = $this->actingAs($candidate2)
        ->getJson('/api/applications/' . $application->id);

    $response->assertStatus(403);
    }
}
