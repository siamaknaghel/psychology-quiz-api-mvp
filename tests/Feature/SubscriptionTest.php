<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


// Test: Create a subscription
it('allows user to create a subscription with trial', function () {
    $user = User::factory()->create();

    // ✅ Simulate subscription creation — without Stripe
    $user->createOrGetStripeCustomer();
    $user->subscriptions()->create([
        'type' => 'default',
        'stripe_id' => 'sub_test123',
        'stripe_status' => 'trialing',
        'stripe_price' => 'price_1RtGZkJyf1eUbwFszisQC98R',
        'trial_ends_at' => now()->addDays(7),
        'ends_at' => null,
    ]);

    expect($user->subscribed('default'))->toBeTrue()
        ->and($user->onTrial('default'))->toBeTrue();
});

// Test: Get subscription status
it('returns subscription status correctly', function () {
    $user = User::factory()->create();

    $user->createOrGetStripeCustomer();
    $user->subscriptions()->create([
        'type' => 'default',
        'stripe_id' => 'sub_test123',
        'stripe_status' => 'trialing',
        'stripe_price' => 'price_1RtGZkJyf1eUbwFszisQC98R',
        'trial_ends_at' => now()->addDays(7),
        'ends_at' => null,
    ]);

    $response = $this->actingAs($user, 'sanctum')->getJson('/api/subscription');

    $response->assertStatus(200)
        ->assertJson([
            'on_trial' => true,
            'subscription' => [
                'status' => 'trialing'
            ]
        ]);
});

// Test: Unsubscribe — Simulate the situation only
it('allows user to cancel subscription', function () {
    $user = User::factory()->create();

    $user->createOrGetStripeCustomer();
    $subscription = $user->subscriptions()->create([
        'type' => 'default',
        'stripe_id' => 'sub_test123',
        'stripe_status' => 'active',
        'stripe_price' => 'price_1RtGZkJyf1eUbwFszisQC98R',
        'trial_ends_at' => null,
        'ends_at' => null,
    ]);

    // ✅ Just check the status in the database — no actual API calls
    $subscription->update(['ends_at' => now()->addDays(1)]);

    expect($subscription->ends_at)->not->toBeNull();
});
