<?php
namespace Database\Factories;

use App\Models\FitnessProgress;
use App\Models\User;
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
            'measurements' => json_encode([
                'chest' => $this->faker->numberBetween(30, 50),
                'waist' => $this->faker->numberBetween(25, 40),
            ]),
            'performance_data' => json_encode([
                'bench_press' => $this->faker->numberBetween(50, 150),
                'squats' => $this->faker->numberBetween(100, 200),
            ]),
            'status' => $this->faker->boolean(),
        ];
    }
}