<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FitnessProgress;

class FitnessProgressController extends Controller
{
    public function index(Request $request)
    {
        $fitnessProgresses = $request->user()->fitnessProgresses;
        return response()->json($fitnessProgresses, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'weight' => 'nullable|numeric',
            'measurements' => 'nullable|json',
            'performance_data' => 'nullable|json',
        ]);

        $fitnessProgress = $request->user()->fitnessProgresses()->create($validatedData);

        return response()->json($fitnessProgress, 201);
    }

    public function show(FitnessProgress $fitnessProgress, Request $request)
    {
        if ($fitnessProgress->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($fitnessProgress, 200);
    }

    public function update(Request $request, FitnessProgress $fitnessProgress)
    {
        if ($fitnessProgress->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validatedData = $request->validate([
            'weight' => 'nullable|numeric',
            'measurements' => 'nullable|json',
            'performance_data' => 'nullable|json',
        ]);

        $fitnessProgress->update($validatedData);

        return response()->json($fitnessProgress, 200);
    }

    public function destroy(FitnessProgress $fitnessProgress, Request $request)
    {
        if ($fitnessProgress->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $fitnessProgress->delete();

        return response()->json(['message' => 'Fitness progress data deleted successfully'], 200);
    }

    public function updateStatus(FitnessProgress $fitnessProgress, Request $request)
    {
        if ($fitnessProgress->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $fitnessProgress->update(['status' => !$fitnessProgress->status]);

        return response()->json($fitnessProgress, 200);
    }
}
