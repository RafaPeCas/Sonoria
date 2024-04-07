<?php

namespace Database\Factories;

use App\Models\UserSong;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSongFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserSong::class;

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
        ];
    }
}
