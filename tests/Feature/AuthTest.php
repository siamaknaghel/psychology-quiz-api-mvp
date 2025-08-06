<?php

// تست: کاربر می‌تونه ثبت‌نام کنه
it('allows user to register', function () {
    $response = $this->postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test-register@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response
        ->assertStatus(201)
        ->assertJsonStructure([
            'message',
            'user' => ['id', 'name', 'email'],
            'token'
        ]);
});

// تست: کاربر می‌تونه با ایمیل و رمز وارد شه
it('allows user to login', function () {
    \App\Models\User::factory()->create([
        'email' => 'login@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'login@example.com',
        'password' => 'password',
    ]);

    $response
        ->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'user' => ['id', 'name', 'email'],
            'token'
        ]);
});

// تست: کاربر می‌تونه پروفایلش رو ببینه
it('allows authenticated user to get their profile', function () {
    $user = \App\Models\User::factory()->create();

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/user');

    $response
        ->assertStatus(200)
        ->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
});

// تست: کاربر می‌تونه خارج بشه
it('allows user to logout', function () {
    $user = \App\Models\User::factory()->create();
    $token = $user->createToken('api-token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
                    ->postJson('/api/logout');

    $response->assertStatus(200)
             ->assertJson(['message' => 'Logged out successfully']);

    $this->assertDatabaseMissing('personal_access_tokens', [
        'tokenable_id' => $user->id,
    ]);
});
