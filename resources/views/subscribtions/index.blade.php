@extends('layouts.profile-layout')

@section('page-title', 'My Subscriptions')
@section('page-header-cont')
<h1>My Subscriptions</h1>
            <h3 class="account-name">Subscribe To get more Reach to your books</h3>
            <p class="account-email"> and make download faster</p>
@endsection
@section('page-styles')
<link  rel="stylesheet" type="text/css" media="screen" href="{{asset('assets/css/subscribtion.css')}}"></link>
@endsection

@section('page-content')
<div class=" pt-5">
    <div class="subscription-card">
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

