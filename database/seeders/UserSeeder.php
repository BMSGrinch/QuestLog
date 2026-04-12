<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //Création de l'admin.
        User::factory()->create(
            [
                'name'=>'Admin',
                'email'=>'admin@questlog.test',
                'role'=>'admin',
            ]
        );

        // Création des user , on va aller sur 105 pour mettre avoir un peu de volume sur les stats
        User::factory()->count(105)->sequence(
            ['role'=>'candidate'],
            ['role'=>'candidate'],
            ['role'=>'candidate'],
            ['role'=>'candidate'],
            ['role'=>'recruiter'],
        )->create();
    }
}
