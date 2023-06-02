<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Values;
use App\Models\Station;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValuesFactory extends Factory
{
    protected $model = Values::class;

    public function definition()
    {
        return [
            'valWindSpeed' => $this->faker->randomFloat(2, 0, 100),
            'valWindDirection' => $this->faker->randomFloat(2, 0, 360),
            'valGust' => $this->faker->randomFloat(2, 0, 100),
            'valEntryDate' => $this->faker->dateTimeThisYear,
            'valStoredDate' => $this->faker->dateTimeThisYear,
            'fkStation' => function () {
                return Station::factory()->create()->idStation;
            }
        ];
    }
}