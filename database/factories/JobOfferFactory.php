<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOffer>
 */
class JobOfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //J'ai pas envie de générer de la merde donc je prends mes précautions.

        $jobs = [ 
            ['title' => 'Développeur PHP/Laravel Senior', 'skills' => 'PHP, Laravel, MySQL, API REST, Git, JavaScript'],
            ['title' => 'Développeur Full Stack JavaScript', 'skills' => 'React, Node.js, MongoDB, REST API, HTML/CSS'],
            ['title' => 'Développeur Python Data Analyst', 'skills' => 'Python, Pandas, SQL, Data Visualization, Machine Learning'],
            ['title' => 'Ingénieur DevOps', 'skills' => 'Docker, Kubernetes, CI/CD, Linux, AWS/Azure'],
            ['title' => 'Développeur Mobile Android', 'skills' => 'Java, Kotlin, Android Studio, Firebase, RESTful API'],
            ['title' => 'Expert Sécurité Informatique', 'skills' => 'Pentest, Cryptographie, Firewall, IDS/IPS, ISO 27001'],
            ['title' => 'Technicien Support Informatique', 'skills' => 'Windows Server, Active Directory, Networking, Troubleshooting'],
            ['title' => 'Architecte Solutions Cloud', 'skills' => 'AWS, Azure, Microservices, Scrum, Enterprise Architecture'],

           
            ['title' => 'Responsable Commercial Régional', 'skills' => 'Gestion commerciale, Négociation, CRM, Leadership, Prospection'],
            ['title' => 'Commercial B2B', 'skills' => 'Prospection, Négociation commerciale, CRM, Reporting'],
            ['title' => 'Vendeur Produits Électroniques', 'skills' => 'Produits tech, Service client, Négociation, Français/Anglais'],
            ['title' => 'Chargé de Relation Client', 'skills' => 'Communication, CRM, Gestion de conflits, Français/Anglais'],
            ['title' => 'Directeur Commercial', 'skills' => 'Management, Stratégie commerciale, Budgeting, Négociation B2B'],
            ['title' => 'Responsable E-commerce', 'skills' => 'Shopify, Marketing digital, SEO, Analytics, Gestion inventaire'],
            ['title' => 'Télévendeur', 'skills' => 'Prospection téléphonique, Persuasion, Français/Anglais, CRM'],

            
            ['title' => 'Infirmier Hospitalier', 'skills' => 'Soins patients, Protocoles médicaux, Dossier médical, Empathie'],
            ['title' => 'Médecin Généraliste', 'skills' => 'Diagnostic, Pharmacologie, Communication, Anglais médical'],
            ['title' => 'Pharmacien', 'skills' => 'Pharmacologie, Gestion stocks médicaments, Conseil clients, Français/Anglais'],
            ['title' => 'Agent de Santé Communautaire', 'skills' => 'Sensibilisation santé, Premiers secours, Communication, Relation patient'],
            ['title' => 'Sage-Femme', 'skills' => 'Obstétrique, Suivi grossesse, Accouchement, Gynécologie'],
            ['title' => 'Administrateur Hôpital', 'skills' => 'Gestion administrative, Budgeting, Ressources humaines, Logiciels médicaux'],

            
            ['title' => 'Professeur de Mathématiques', 'skills' => 'Pédagogie, Mathématiques avancées, Gestion classe, TIC'],
            ['title' => 'Formateur Professionnel', 'skills' => 'Conception pédagogique, Animation formation, Évaluation, Anglais'],
            ['title' => 'Professeur d\'Anglais', 'skills' => 'Anglais courant/natif, Pédagogie, Grammaire, Littérature'],
            ['title' => 'Ingénieur Pédagogique', 'skills' => 'ADDIE, LMS, E-learning, Scénarios pédagogiques, Moodle'],
            ['title' => 'Responsable Formation RH', 'skills' => 'Ingénierie formation, GPEC, Budget formation, Evaluation'],
            ['title' => 'Professeur Informatique', 'skills' => 'Informatique générale, Programmation, Réseaux, Pédagogie'],
            ['title' => 'Coach Linguistique', 'skills' => 'Français/Anglais, Coaching, Communication interculturelle'],
            ['title' => 'Chargé de Curriculum', 'skills' => 'Conception curriculum, Alignement pédagogique, Normes éducation'],

            
            ['title' => 'Chauffeur Poids Lourd', 'skills' => 'Permis PL, Sécurité routière, Entretien véhicule, Communication'],
            ['title' => 'Gestionnaire de Stock', 'skills' => 'Inventaire, ERP, Excel, Gestion entrepôt, Rapport qualité'],
            ['title' => 'Responsable Logistique', 'skills' => 'Supply Chain, WMS, Optimisation coûts, Management, Français/Anglais'],
            ['title' => 'Magasinier', 'skills' => 'Manutention, Rangement, Picking, Sécurité, Attention détails'],
            ['title' => 'Transitaire', 'skills' => 'Douanes, Incoterms, Documentation, Anglais, Réglementation import/export'],
            ['title' => 'Chauffeur Livreur', 'skills' => 'Permis B, Service client, Traçabilité, Sécurité routière'],
            ['title' => 'Coordinateur Expéditions', 'skills' => 'Planification, Suivi livraisons, Communication clients, Excel/Outlook'],
            ['title' => 'Opérateur Manutention', 'skills' => 'Manutention manuelle, Sécurité, Ponctualité, Endurance physique'],

           
            ['title' => 'Comptable Senior', 'skills' => 'Comptabilité générale, SYSCOHADA, Audit, Anglais, Sage/QuickBooks'],
            ['title' => 'Analysant Financier', 'skills' => 'Analyse bilan, Modélisation financière, Excel avancé, Audit'],
            ['title' => 'Trésorier', 'skills' => 'Gestion trésorerie, Flux cash, Placements, Reporting, Anglais'],
            ['title' => 'Auditeur Interne', 'skills' => 'Audit interne, Risk management, COSO, Français/Anglais'],
            ['title' => 'Contrôleur de Gestion', 'skills' => 'Budgeting, Costing, KPI, Reporting management, Excel/BI'],
            ['title' => 'Spécialiste Conformité Fiscale', 'skills' => 'Fiscalité Côte d\'Ivoire, CGIAR, Droit fiscal, Compliance'],
            ['title' => 'Analyste Crédit', 'skills' => 'Analyse dossier crédit, Scoring, Risk assessment, Français/Anglais'],
            ['title' => 'Paie et Administration Personnel', 'skills' => 'Paie, CNPS, CNAM, Droit travail, Sage/Paie'],

            
            ['title' => 'Gestionnaire Ressources Humaines', 'skills' => 'SIRH, Recrutement, Paie, Droit travail, Gestion talents'],
            ['title' => 'Recruteur', 'skills' => 'Sourcing, Entretien, Évaluation candidats, Linkedin, Français/Anglais'],
            ['title' => 'Responsable Développement Soft Skills', 'skills' => 'Leadership, Coaching, Bien-être au travail, Facilitation, Empathie'],
            ['title' => 'Directeur Ressources Humaines', 'skills' => 'Stratégie RH, Management équipe, Gestion conflits, Budgeting, Leadership'],
        ];
            $job = $this->faker->randomElement($jobs);

        $locations = ['Abidjan', 'Yamoussoukro', 'Bouaké', 'Daloa', 'San Pedro', 'Korhogo'
        ];

        $salaries = ['150 000 - 250 000 FCFA', '250 000 - 400 000 FCFA', '400 000 - 600 000 FCFA','600 000 - 800 000 FCFA', 'Selon profil...'];
        
        $expMin =$this->faker->numberBetween(0,5);

        $createdAt=$this->faker->dateTimeBetween('-6 months','now');

        return [
            'recruiter_id'=>User::where('role','recruiter')->inRandomOrder()->first()->id,
            'title' => $job['title'],
            'company'=>$this->faker->company(),
            'description'=>$this->faker->paragraph(3),
            'location' => $locations[$this->faker->numberBetween(0, count($locations) - 1)],
            'contract_type'=>$this->faker->randomElement(['CDI','CDD','Stage','Freelance']),
            'salary' => $salaries[$this->faker->numberBetween(0, count($salaries) - 1)],
            'experience_min'=>$expMin,
            'experience_max'=>$this->faker->numberBetween($expMin,$expMin + 5),
            'skills_required' => $job['skills'],
            'application_deadline'=>$this->faker->dateTimeBetween($createdAt , '+3 months'),
            'remote_policy'=>$this->faker->randomElement(['onsite','remote','hybrid']),
            'status'=>$this->faker->randomElement(['draft','open','closed']),
            'created_at'=>$createdAt,
            'updated_at'=>$createdAt
        ];
    }
}
