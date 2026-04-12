<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $positions = ['Développeur Full Stack','Chef de Ventes','Infirmier/Infirmière','Agent Administratif','Directeur Financier','Professeur de Lycée','Mécanicien Automobile','Responsable RH','Physiothérapeute','Inspecteur Douane','Agriculteur','Comptable','Ingénieur Civil','Secrétaire de Direction','Juriste','Électricien','Gestionnaire de Stocks','Vendeur de Pharmacie','Technicien Télécom','Traducteur','Chauffeur de Transport','Boulanger','Responsable Marketing','Plombier','Statisticien','Gardien de Sécurité','Couturier/Couturière','Officier de Banque','Mécanicien Engins Agricoles','Coordinateur Projet ONG'
];
        //La flemme d'avoir de mettre des données manuellement va me perdre mdr. En gros là faut qu'on trouve un moyen de ne pas avoir de candidatures incohérentes.Bon j'ai vu un truc sur un forum obscur mais on a va tenter.
        

        //On va créer un truc comme 300 candidatures dont 70% viennent d'offre de QL et 30% viennent des candidats eux même.
           
        //70% QL 
        JobOffer::all()->each(function ($offer) {
            $count = rand(2 , 5);
            
            Application::factory()->count($count)->create([
                'job_offer_id'=> $offer->id,
                'applied_at'=>fake()->dateTimeBetween(
                    $offer->created_at->addDays(3),
                    'now'
                ),
                'company_name'=>null ,
                'position' => null,
                'job_link'=>null,
            ])->each(
                function ($application) use ($offer) {
                    if(rand(0, 1)){
                        $application->applicationStatusHistories()->create([
                        'old_status'=>'applied',
                        'new_status'=>fake()->randomElement(['screening','interview','rejected','accepted']),
                        'changed_by'=> $offer->recruiter_id,                    
                        'changed_at'=>fake()->dateTimeBetween($application->applied_at , 'now')
                        ]);
                        
                    }
                }
            ); //Création du changement de status pour les tests (dans la réalité , ce code ne devrait pas exister mais bon)
        });

        //30% hors QL
        for($i = 0 ; $i<90 ; $i++){
            Application::factory()->create([
            'job_offer_id'=>null,
            'company_name'=>fake()->company(),
            'position'=>fake()->randomElement($positions),
            'job_link'=>fake()->optional(0.7)->url(),
            
        ]);
        }
       
    }
}
