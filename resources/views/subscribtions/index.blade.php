@extends('layouts.user')

@section('user-title', 'My Subscription')

@section('user-styles')
<style>
    .subscription-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .subscription-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .subscription-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .subscription-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
    }
    
    .subscription-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .status-active {
        background-color: #e8f5e9;
        color: #2e7d32;
    }
    
    .status-inactive {
        background-color: #ffebee;
        color: #c62828;
    }
    
    .plan-features {
        margin: 1.5rem 0;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .feature-item i {
        color: #ff5c28;
        margin-right: 0.75rem;
    }
    
    .plan-price {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
        margin: 1rem 0;
    }
    
    .price-period {
        font-size: 1rem;
        font-weight: 400;
        color: #666;
    }
    
    .btn-subscribe {
        background-color: #ff5c28;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
        display: inline-block;
        margin-top: 1rem;
        text-decoration: none;
    }
    
    .btn-subscribe:hover {
        background-color: #e04b20;
    }
    
    .btn-outline {
        background: transparent;
        border: 1px solid #ff5c28;
        color: #ff5c28;
    }
    
    .btn-outline:hover {
        background: rgba(255, 92, 40, 0.1);
    }
    
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .plan-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    .plan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .plan-card h3 {
        font-size: 1.25rem;
        margin-bottom: 1rem;
    }
    
    .plan-card.highlighted {
        border: 2px solid #ff5c28;
        position: relative;
    }
    
    .highlight-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: #ff5c28;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .payment-history {
        margin-top: 3rem;
    }
    
    .history-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }
    
    .history-table th, .history-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #eee;
    }
    
    .history-table th {
        font-weight: 600;
        color: #555;
    }
    
    .status-paid {
        color: #2e7d32;
    }
    
    .status-failed {
        color: #c62828;
    }
</style>
@endsection

@section('user-content')
<div class="subscription-container pt-5">
    <div class="subscription-card mt-5">
        <div class="subscription-header">
            <h2 class="subscription-title">My Subscription</h2>
            @if($activeSubscription)
                <span class="subscription-status status-active">Active</span>
            @else
                <span class="subscription-status status-inactive">Not Subscribed</span>
            @endif
        </div>
        
        @if($activeSubscription)
            <div class="current-plan">
                <h3>{{ $activeSubscription->plan_type }} Plan</h3>
                <div class="plan-price">
                    ${{ number_format($planOptions[$activeSubscription->plan_type]['price'], 2) }}
                    <span class="price-period">/ month</span>
                </div>
                
                <div class="plan-features">
                    @foreach($planOptions[$activeSubscription->plan_type]['features'] as $feature)
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>
                
                <p>Started on: {{ $activeSubscription->start_date->format('M d, Y') }}</p>
                @if($activeSubscription->end_date)
                    <p>Renews on: {{ $activeSubscription->end_date->format('M d, Y') }}</p>
                @else
                    <p>Auto-renewing subscription</p>
                @endif
                
                <a href="#" class="btn-subscribe btn-outline">Manage Subscription</a>
                <a href="#" class="btn-subscribe" style="background-color: #f44336;">Cancel Subscription</a>
            </div>
        @else
            <p>You don't have an active subscription. Choose a plan below to get started.</p>
        @endif
    </div>
    
    @if(!$activeSubscription || $activeSubscription->plan_type === 'Free')
        <div class="subscription-card">
            <h2 class="subscription-title">Available Plans</h2>
            
            <div class="plans-grid">
                @foreach($planOptions as $planName => $planDetails)
                    <div class="plan-card {{ $planName === 'Premium' ? 'highlighted' : '' }}">
                        @if($planName === 'Premium')
                            <span class="highlight-badge">Most Popular</span>
                        @endif
                        <h3>{{ $planName }} Plan</h3>
                        <div class="plan-price">
                            ${{ number_format($planDetails['price'], 2) }}
                            <span class="price-period">/ month</span>
                        </div>
                        
                        <div class="plan-features">
                            @foreach($planDetails['features'] as $feature)
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                        
                        <a href="#" class="btn-subscribe {{ $planName === 'Premium' ? '' : 'btn-outline' }}">
                            {{ $planName === 'Premium' ? 'Start Premium' : 'Continue Free' }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <div class="subscription-card payment-history">
        <h2 class="subscription-title">Payment History</h2>
        
        @if($paymentHistory->count() > 0)
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentHistory as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>{{ $payment->subscription->plan_type }} Plan Subscription</td>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td class="status-{{ strtolower($payment->status) }}">{{ $payment->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No payment history found.</p>
        @endif
    </div>
</div>
@endsection

