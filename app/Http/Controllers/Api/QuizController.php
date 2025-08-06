<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function questions()
    {
        return response()->json([
            'success' => true,
            'data' => Question::with('options')->get()
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'exists:options,id'
        ]);

        $answers = $request->answers;
        $traits = [];

        foreach ($answers as $questionId => $optionId) {
            $option = \App\Models\Option::find($optionId);
            $trait = $option->trait;
            $traits[$trait] = ($traits[$trait] ?? 0) + $option->weight;
        }

        $total = array_sum($traits);
        $percentages = array_map(fn($v) => round(($v / $total) * 100, 2), $traits);

        $result = QuizResult::create([
            'user_id' => $request->user()->id,
            'answers' => $answers,
            'traits' => $percentages,
        ]);

        return response()->json([
            'message' => 'Quiz submitted successfully',
            'result' => $result
        ]);
    }

    public function history(Request $request)
    {
        $results = $request->user()->quizResults()->latest()->get();

        return response()->json([
            'results' => $results
        ]);
    }
}
