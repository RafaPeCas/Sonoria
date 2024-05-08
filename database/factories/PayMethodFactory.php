<?php

namespace Database\Factories;

use App\Models\PayMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PayMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PayMethod::class;

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
            'card_holder' => $this->faker->name,
            'card_number' => $this->faker->creditCardNumber,
            'cvv' => $this->faker->randomNumber(3),
            'deleted' => false,
        ];
    }
}

?>
