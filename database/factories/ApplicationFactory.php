<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $appliedAt = $this->faker->dateTimeBetween('-6 months' , 'now');
        return [
            //
        'candidate_id'=> User::where('role','candidate')->inRandomOrder()->first()->id,
        'job_offer_id'=> null,
        'company_name'=> null,
        'position'=> null ,
        'job_link'=> null,
        'status'=> fake()->randomElement(['applied','screening','interview','rejected','accepted']),
        'applied_at'=>$appliedAt,
        'notes'=>$this->faker->optional(0,4)->sentence(),
        ];
    }
}
