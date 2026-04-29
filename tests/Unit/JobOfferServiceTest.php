<?php

namespace Tests\Unit;

use App\Models\JobOffer;
use App\Models\User;
use App\Services\JobOfferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobOfferServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_creer_une_offre_avec_des_donnees_valide()
    {
        // ARRANGE : C'est la partie préparation des données en gros je mets infos de ce que je veux tester

        $recruiter = User::factory()->create(['role'=>'recruiter']);
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

        // ACT : C'est la partie où on appelle la methode à tester donc ici c'est jobofferservice

        $service = new JobOfferService();
        $offre = $service->createJobOffer($recruiter->id , $data);

        //ASSERT : C'est la partie où on vérifie que les résultats sont ce qu'on attendait.

        $this->assertNotNull($offre);//logique on s'attend à ce que l'offre soit créée donc elle ne devrait pas être nulle normalement,
        $this->assertEquals('Développeur Laravel', $offre->title);//On s'attend à ce que le titre de l'offre soit le même que le baye fourni en haut
        $this->assertEquals($recruiter->id, $offre->recruiter->id);// On s'attend à ce que le recruteur de l'offre soit le même que celui qu'on a créé en haut
        $this->assertDatabaseHas('job_offers',['title'=>'Développeur Laravel' , 'recruiter_id' => $recruiter->id]);//On s'attend à ce que la base de données contienne une offre avec le titre "Développeur Laravel"et le recruteur_id correspondant à celui du recruteur qu'on a créé en haut
    }

    public function test_modifier_une_offre_avec_des_donnees_valide()
    {
        // ARRANGE : C'est la partie préparation des données en gros je mets infos de ce que je veux tester

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
            'status' => 'open',]);

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

        // ACT : C'est la partie où on appelle la methode à tester donc ici c'est jobofferservice

        $service = new JobOfferService();
        $updatedOffer = $service->updateJobOffer($newData , $jobOffer);

        //ASSERT : C'est la partie où on vérifie que les résultats sont ce qu'on attendait.

        $this->assertEquals('Développeur Symfony', $updatedOffer->title);//logique on s'attend à ce que modifier les infos pour avoir ça ,
        $this->assertEquals( $jobOffer->recruiter_id ,$updatedOffer->recruiter_id);//On s'attend à ce que le recruteur soit toujours le même que celui qui a crée l'offre au départ
        $this->assertDatabaseHas('job_offers',['id' => $jobOffer->id , 'title'=>'Développeur Symfony' , 'recruiter_id' => $recruiter->id]);//On s'attend à ce que la base de données contienne une offre avec le titre "Développeur Symfony"et le recruteur_id correspondant à celui du recruteur qu'on a créé en haut
    }
}
