<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Get user subscription status
     */
    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'subscription' => $user->subscribed('default') ? [
                'status' => $user->subscription('default')->stripe_status,
                'ends_at' => $user->subscription('default')->ends_at,
                'trial_ends_at' => $user->subscription('default')->trial_ends_at,
            ] : null,
            'on_trial' => $user->onTrial('default'),
            'on_grace_period' => $user->subscription('default')?->onGracePeriod(),
        ]);
    }

    /**
     * Start subscription (with trial period)
     */
    public function create(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
        ]);

        $user = $request->user();

        $user->createOrGetStripeCustomer();
        // ⚠️ This is a test subscription created manually in the Stripe dashboard.
        // In the future, this should be dynamic:
        // 1. Admin creates a product and price via the admin panel.
        // 2. The system automatically creates it in Stripe.
        // 3. The price ID should be fetched from the database and used here
        $user->newSubscription('default', 'price_1RtGZkJyf1eUbwFszisQC98R')
             ->trialDays(7)
             ->create($request->payment_method);

        return response()->json([
            'message' => 'Subscription started successfully',
            'subscription' => $user->subscription('default')
        ]);
    }

    /**
     * Unsubscribe
     */
    public function cancel(Request $request)
    {
        $user = $request->user();

        if ($user->subscribed('default')) {
            $user->subscription('default')->cancel();
        }

        return response()->json([
            'message' => 'Subscription canceled. You can continue using the service until the end of the billing period.'
        ]);
    }

    /**
     * Renewing a canceled subscription (during the grace period)
     */
    public function resume(Request $request)
    {
        $user = $request->user();

        if ($user->subscription('default')?->onGracePeriod()) {
            $user->subscription('default')->resume();
            return response()->json(['message' => 'Subscription resumed']);
        }

        return response()->json(['error' => 'No subscription to resume'], 400);
    }
}
