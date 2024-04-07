<?php

// database/factories/SubscriptionFactory.php

namespace Database\Factories;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

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
            'active' => true,
            'name' => $this->faker->sentence(),
        ];
    }
}


?>
