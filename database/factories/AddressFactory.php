<?php
namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10), 
            'province' => $this->faker->state,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'number' => $this->faker->buildingNumber,
            'pc' => $this->faker->postcode,
            'country' => $this->faker->country,
        ];
    }
}
?>
