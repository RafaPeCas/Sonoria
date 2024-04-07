<?php
// database/factories/InvoiceFactory.php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

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
            'payMethod_id' => function () {
                return \App\Models\PayMethod::factory()->create()->id;
            },
            'address_id' => function () {
                return \App\Models\Address::factory()->create()->id;
            },
            'total' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}


?>
