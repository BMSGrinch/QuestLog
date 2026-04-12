<?php

namespace Database\Factories;

use App\Models\JobOffer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobOfferView>
 */
class JobOfferViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         
        return [
            //
            'job_offer_id'=>JobOffer::inRandomOrder()->first()->id,
            'ip_address'=>fake()->ipv4(),
            'viewed_at'=>fake()->dateTimeBetween('-6 months','now'),
        ];
    }
}
