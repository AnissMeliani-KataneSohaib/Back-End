<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash; // Ajout de la référence à la classe Hash

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Médecin>
 */
class MédecinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nom' => $this->faker->name(), 
            'prenom' => $this->faker->name(), 
            'email' => $this->faker->unique()->safeEmail(), 
            'role' => $this->faker->name(), 
            'telephone' => $this->faker->phoneNumber(), 
            'specialité' => $this->faker->name(), 
            'departement_id' => $this->faker->numberBetween(1, 5), 
            'password' => Hash::make('password'), 

        ];
    }
}
