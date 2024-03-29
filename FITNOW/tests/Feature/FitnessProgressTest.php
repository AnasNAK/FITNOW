<?php
// tests/Feature/FitnessProgressTest.php

namespace Tests\Feature;

use App\Models\FitnessProgress;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FitnessProgressTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateFitnessProgress()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;

        $response = $this->postJson('/api/fitness-progresses', [
            'weight' => 75.5,
            'measurements' => json_encode(['chest' => 40, 'waist' => 32]),
            'performance_data' => json_encode(['bench_press' => 100, 'squats' => 150]),
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'user_id' => $user->id,
                'weight' => 75.5,
                'measurements' => json_decode('{"chest":40,"waist":32}', true),
                'performance_data' => json_decode('{"bench_press":100,"squats":150}', true),
                'status' => false,
            ]);
    }

    public function testUpdateFitnessProgress()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);

        $response = $this->patchJson("/api/fitness-progresses/{$fitnessProgress->id}", [

            'weight' => 80.0,
            'measurements' => json_encode(['chest' => 42, 'waist' => 30]),
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $fitnessProgress->id,
                'user_id' => $user->id,
                'weight' => 80.0,
                'measurements' => json_decode('{"chest":42,"waist":30}', true),
                'performance_data' => null,
                'status' => false,
            ]);
    }

    public function testDeleteFitnessProgress()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson("/api/fitness_progresses/{$fitnessProgress->id}", [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Fitness progress data deleted successfully',
            ]);

        $this->assertDatabaseMissing('fitness_progresses', [
            'id' => $fitnessProgress->id,
            'user_id' => $user->id,
        ]);
    }

    public function testGetFitnessProgress()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/fitness_progresses/{$fitnessProgress->id}", [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $fitnessProgress->id,
                'user_id' => $user->id,
                'weight' => $fitnessProgress->weight,
                'measurements' => $fitnessProgress->measurements,
                'performance_data' => $fitnessProgress->performance_data,
                'status' => $fitnessProgress->status,
            ]);
    }
}