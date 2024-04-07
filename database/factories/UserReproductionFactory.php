<?php

namespace Database\Factories;

use App\Models\UserReproduction;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserReproductionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserReproduction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'song_id' => function () {
                return \App\Models\Song::factory()->create()->id;
            },
            'reproductions' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
