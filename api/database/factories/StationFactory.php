<?php
/**
 * ETML
 * Author : João Ferreira
 * Date : 02.06.2023
 * Description : Factory of the Station model that generates fake data  
 */

namespace Database\Factories;

use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class StationFactory extends Factory
{
    // model class corresponding
    protected $model = Station::class;

    /**
     * Define the model's default fake variables
     * 
     * @return array of the fake data
     */
    public function definition()
    {
        return [
            'idStation' => $this->faker->unique()->regexify('[A-Z]{3}'),
            'staName' => $this->faker->city,
            'staImg' => $this->faker->imageUrl()
        ];
    }
}