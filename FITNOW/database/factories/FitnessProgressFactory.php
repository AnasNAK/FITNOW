<?php

namespace Database\Factories;
// database/factories/FitnessProgressFactory.php

use App\Models\User;
use App\Models\FitnessProgress;
use Illuminate\Database\Eloquent\Factories\Factory;

class FitnessProgressFactory extends Factory
{
    protected $model = FitnessProgress::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'weight' => $this->faker->randomFloat(2, 50, 100),
            'measurements' => $this->faker->randomElement(['{"chest":40,"waist":32}', '{"chest":42,"waist":30}']),
            'performance_data' => $this->faker->randomElement(['{"bench_press":100,"squats":150}', null]),
            'status' => $this->faker->boolean(),
        ];
    }
}
