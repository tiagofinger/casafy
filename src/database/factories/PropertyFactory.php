<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->numberBetween(1, 6),
            'total_area' => $this->faker->numberBetween(1, 400),
            'purchased' => $this->faker->boolean,
            'value' => $this->faker->numberBetween(100000, 700000),
            'discount' => $this->faker->numberBetween(0, 100),
            'owner_id' => 1,
            'expired' => $this->faker->boolean,
        ];
    }
}
