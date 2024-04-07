<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['pop', 'rock', 'rap', 'hip-hop', 'alternative']),
            // Define aquí otros atributos si los tienes
        ];
    }
}
