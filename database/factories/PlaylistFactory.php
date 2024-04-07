<?php

namespace Database\Factories;

use App\Models\Playlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaylistFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Playlist::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'visibility' => $this->faker->randomElement(['public', 'private']),
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
            'fav' => $this->faker->boolean,
        ];
    }
}

