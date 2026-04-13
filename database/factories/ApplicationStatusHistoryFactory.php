<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApplicationStatusHistory>
 */
class ApplicationStatusHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['applied','screening','interview','rejected','accepted'];
        $oldStatus = fake()->randomElement($status);
        $newStatus = fake()->randomElement(array_values(array_filter($status , fn($s) => $s !== $oldStatus)));
        
        return [
            // 
            'old_status'=>$oldStatus,
            'new_status'=>$newStatus,
            'changed_at'=>fake()->dateTimeBetween('-6 months','now'),

        ];
    }
}
