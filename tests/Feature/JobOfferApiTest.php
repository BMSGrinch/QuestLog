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
        $this->assertDatabaseHas('job_offers' , ['title'=>'Développeur Laravel']);
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

        $response = $this->actingAs($recruiter)->putJson('/api/job-offers/'.$jobOffer->id ,$newData);

        // ASSERT 
        
        $response->assertStatus(200)->assertJsonPath('data.title','Développeur Symfony');
    }

    public function test_un_recruteur_ne_peut_pas_modifier_loffre_dun_autre(){
        //ARRANGE
        $recruiter1 = User::factory()->create(['role'=>'recruiter']);
        $recruiter2 = User::factory()->create(['role'=>'recruiter']);
        $jobOffer = JobOffer::factory()->create(['recruiter_id'=>$recruiter1->id]);

        //ACT
        $response =$this->actingAs($recruiter2)->putJson('/api/job-offers/'.$jobOffer->id , ['title'=>'test']);

        //ASSERT
        $response->assertStatus(403);
    }


    //Le but de ce test est de vérifier que le recruteur ne peut pas rentrer n'importe quel merde. On est pas dans un champ mdr. Je sais que normalement c'est un peu bizarre de faire un test pour quelque chose qui ne marche pas mais apparemment c'est comme ça qu'on doit faire les tests.
    public function test_cration_offre_validation_des_champs(){
        //ARRANGE
        $recruiter = User::factory()->create(['role'=>'recruiter']);

        //ACT
        $response = $this->actingAs($recruiter)->postJson('/api/job-offers/' , ['title'=>'' , 'experience_min'=>'test']);

        //ASSERT
        $response->assertStatus(422)->assertJsonValidationErrors(['title', 'experience_min']);
    }

    public function test_un_utilisateur_non_connecte_ne_peut_pas_creer_doffre(){
        //ARRANGE : on met rien y a aucune donnée à entrer vu que l'utilisateur n'est pas co

        //ACT 
        $response = $this->postJson('/api/job-offers/' , ['title'=>'test']);

        //ASSERT
        $response->assertStatus(401);
        
    }
}
