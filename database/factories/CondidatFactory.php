<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Condidat>
 */
class CondidatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cin'=>fake()->name(),
            'nom'=>fake()->name(),
            'prenom'=>fake()->name(),
            'email'=>fake()->email(),
            
        ];
    }
}
