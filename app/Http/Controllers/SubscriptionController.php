<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Payment;

class SubscriptionController extends Controller
{
    /**
     * Display the subscription dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $activeSubscription = $user->subscriptions()
            ->where('end_date', '>=', now())
            ->orWhereNull('end_date')
            ->latest()
            ->first();

        $paymentHistory = $user->payments()
            ->with('subscription')
            ->orderBy('payment_date', 'desc')
            ->get();

        $planOptions = [
            'Free' => [
                'price' => 0,
                'features' => [
                    'Limited audiobook access',
                    'Basic listening features',
                    '1 device'
                ]
            ],
            'Premium' => [
                'price' => 9.99,
                'features' => [
                    'Unlimited audiobook access',
                    'Offline listening',
                    'Multiple devices',
                    'Exclusive content',
                    'No ads'
                ]
            ]
        ];

        return view('subscribtions.index', [
            'activeSubscription' => $activeSubscription,
            'paymentHistory' => $paymentHistory,
            'planOptions' => $planOptions,
            'user' => $user
        ]);
    }
}