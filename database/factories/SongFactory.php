<?php
// database/factories/SongFactory.php

namespace Database\Factories;

use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

class SongFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Song::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file' => $this->faker->url(),
            'explicit' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'hidden' => $this->faker->boolean(),
            'name' => $this->faker->sentence(),
            'reproductions' => $this->faker->numberBetween(0, 1000),
            'image' => $this->faker->imageUrl(),
            'album_id' => function () {
                return \App\Models\Album::factory()->create()->id;
            },'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}

?>
