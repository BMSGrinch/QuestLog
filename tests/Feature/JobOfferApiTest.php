<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use Tests\TestCase;

class JobOfferApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_creer_une_offre_demploie_par_api() 
    {
        // ARRANGE

    $recruiter = User::factory()->create(['role' => 'recruiter']);
       $data = [
            'title' => 'Développeur Laravel',
            'company' => 'Acme CI',
            'description' => 'Un poste sympa',
            'location' => 'Abidjan',
            'contract_type' => 'CDI',
            'experience_min' => 1,
            'skills_required' => 'Laravel, PHP',
            'remote_policy' => 'onsite',
            'status' => 'open',
        ];

        // ACT 

        $respnse = $this->actingAs($recruiter)//Pour simuler la connexion 
        ->postJson('/api/job-offers', $data) // on recup les données via la route api 
        ;

        // ASSERT
        $respnse->assertStatus(201)->assertJsonPath('data.title', 'Développeur Laravel');
        $this->assertDatabaseHas('job-offers' , ['title'=>'Développeur Laravel']);
    }

    public function test_modifier_une_offre_demploie_par_api(){

        //ARRANGE

        $recruiter = User::factory()->create(['role'=>'recruiter']);
        $jobOffer = JobOffer::factory()->create([
            'title' => 'Développeur Laravel',
            'company' => 'Acme CI',
            'description' => 'Un poste sympa',
            'location' => 'Abidjan',
            'contract_type' => 'CDI',
            'experience_min' => 1,
            'skills_required' => 'Laravel, PHP',
            'remote_policy' => 'onsite',
            'status' => 'open',
        ]);
        $newData = [
            'title' => 'Développeur Symfony',
            'company' => 'Acme CI',
            'description' => 'Un poste sympa',
            'location' => 'Abidjan',
            'contract_type' => 'CDI',
            'experience_min' => 2,
            'skills_required' => 'Symfony, PHP',
            'remote_policy' => 'onsite',
            'status' => 'open',
        ]; 

        // ACT

        $response = $this->actingAs($recruiter)->postJson('/api/job-offers/{$offer->id}',$newData);

        // ASSERT 
        
        $response->assertStatus(200);

        $this->assertDatabaseHas('jobOffers',[
            
        ]);
    }
}
