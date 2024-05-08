<?php
// database/factories/SearchFactory.php

namespace Database\Factories;

use App\Models\Search;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Search::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'search' => $this->faker->sentence(),
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}

?>
