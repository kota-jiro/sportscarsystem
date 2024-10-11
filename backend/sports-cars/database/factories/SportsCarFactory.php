<?php

namespace Database\Factories;

use App\Models\SportsCar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SportsCar>
 */
class SportsCarFactory extends Factory
{
    protected $model = SportsCar::class;

    public function definition(): array
    {
        return [
            'make' => $this->faker->company(),
            'model' => $this->faker->word(),
            'year' => $this->faker->year(),
            'price' => $this->faker->randomFloat(2, 10000, 500000),
        ];
    }
}
