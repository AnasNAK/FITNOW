<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\FitnessProgress;

class FitnessProgressTest extends TestCase
{
    use RefreshDatabase;

    public function testDeleteFitnessProgress()
    {
        $user = User::factory()->create();
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);
        $token = $user->createToken('authToken')->plainTextToken;
    
        $response = $this->actingAs($user)->deleteJson("/api/fitness-progresses/{$fitnessProgress->id}");
    
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Fitness progress data deleted successfully',
            ]);
    
        $this->assertDatabaseMissing('fitness_progresses', ['id' => $fitnessProgress->id]);
    }
    

    public function testUpdateFitnessProgress()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->patchJson("/api/fitness-progresses/{$fitnessProgress->id}", [
            'weight' => 80.0,
            'measurements' => json_encode(['chest' => 42, 'waist' => 30]),
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200); 
    }
    public function testUpdateFitnessProgressStatus()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->patchJson("/api/fitness-progresses/{$fitnessProgress->id}/status", [
            'status' => true,
      
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200); 
    }


    public function testCreateFitnessProgress()
    {
        $user = User::factory()->create();
        $token = $user->createToken('authToken')->plainTextToken;
    
        $response = $this->actingAs($user)->postJson('/api/fitness-progresses', [
            'weight' => 70.0, 
            'measurements' => json_encode(['chest' => 40, 'waist' => 32]),
            'performance_data' => json_encode(['bench_press' => 100, 'squats' => 150]),
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(201); 
    }
    

    public function testGetFitnessProgress()
     {
        $user = User::factory()->create();
        $fitnessProgress = FitnessProgress::factory()->create(['user_id' => $user->id]);
    
        $response = $this->actingAs($user)->getJson("/api/fitness-progresses/{$fitnessProgress->id}");
    
        $response->assertStatus(200);
    }
    
}
