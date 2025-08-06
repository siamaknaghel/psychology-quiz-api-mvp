<?php

use App\Models\QuizResult;

// تست: دریافت سوالات
it('returns quiz questions with options from seed', function () {
    $user = \App\Models\User::factory()->create();
    $this->seed(\Database\Seeders\QuizDataSeeder::class);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/quiz/questions');

    $response
        ->assertStatus(200)
        ->assertJsonPath('data.0.text', 'Do you prefer to spend your time alone?')
        ->assertJsonCount(7, 'data')
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => ['id', 'text', 'options']
            ]
        ]);
});

// تست: سابمیت پاسخ کوئیز
it('allows user to submit quiz and get result', function () {
    $user = \App\Models\User::factory()->create();
    $this->seed(\Database\Seeders\QuizDataSeeder::class);

    $questions = \App\Models\Question::with('options')->get();
    $answers = [];

    foreach ($questions as $q) {
        $answers[$q->id] = $q->options->first()->id;
    }

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/quiz/submit', [
            'answers' => $answers
        ]);

    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Quiz submitted successfully'
        ])
        ->assertJsonStructure([
            'result' => [
                'id',
                'user_id',
                'answers',
                'traits',
                'created_at'
            ]
        ]);

    $this->assertDatabaseHas('quiz_results', [
        'user_id' => $user->id,
        'answers' => json_encode($answers),
    ]);
});

// تست: دریافت تاریخچه کوئیز
it('returns quiz history for user', function () {
    $user = \App\Models\User::factory()->create();
    $this->seed(\Database\Seeders\QuizDataSeeder::class);

    QuizResult::create([
        'user_id' => $user->id,
        'answers' => [1 => 1, 2 => 6, 3 => 11, 4 => 16, 5 => 21, 6 => 26, 7 => 31],
        'traits' => ['introvert' => 80, 'extrovert' => 20]
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->getJson('/api/quiz/history');

    $response
        ->assertStatus(200)
        ->assertJsonCount(1, 'results')
        ->assertJsonStructure([
            'results' => [
                '*' => ['id', 'user_id', 'answers', 'traits', 'created_at']
            ]
        ]);
});
