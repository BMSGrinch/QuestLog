<?php

namespace Database\Seeders;

use App\Models\JobOffer;
use App\Models\JobOfferView;
use Illuminate\Database\Seeder;

class JobOfferViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 
        JobOffer::all()->each(function ($offer) {
            $count = rand(3, 80);
            JobOfferView::factory()->count($count)->state(function() use ($offer){
                return [
                     'job_offer_id'=>$offer->id,
                     'ip_address'=>fake()->ipv4(),
                    'viewed_at'=>fake()->dateTimeBetween($offer->created_at, 'now'),
                ];
            })->create();
        });
    }
}
