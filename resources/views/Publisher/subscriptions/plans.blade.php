@extends('layouts.profile-layout')

@section('page-title', 'Subscription Plans')
@section('page-header-cont')
<h1>Available Subscription Plans</h1>
<h3 class="account-name">Subscribe To get more Reach to your books</h3>
<p class="account-email">and make download faster</p>
@endsection

@section('page-styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('assets/css/subscribtion.css')}}">
<style>
    .plans-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .plan-card {
        border-radius: 12px;
        padding: 2rem;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .plan-card:hover {
        transform: translateY(-5px);
    }
    
    .plan-card.highlighted {
        border: 2px solid #ff5c28;
        transform: scale(1.02);
    }
    
    .highlight-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: #ff5c28;
        color: white;
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 1;
    }
    
    .plan-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .plan-price {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #ff5c28;
    }
    
    .price-period {
        font-size: 1rem;
        color: #666;
        font-weight: normal;
    }
    
    .free-demo {
        background: #FF9800;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 1rem;
        font-size: 0.8rem;
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
        margin-right: 0.5rem;
        color: #ff5c28;
    }
    
    .btn-subscribe {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 6px;
        background: #ff5c28;
        color: white;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: 1rem;
    }
    
    .btn-subscribe:hover {
        background: #3e8e41;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-subscribe:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .expiry-info {
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #666;
        text-align: center;
    }
    
    .current-plan-badge {
        background: #2196F3;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>
@endsection

@section('page-content')
<div class="plans-container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

      
    <div class="plans-grid d-flex ">
                        @foreach($plans as $plan)
                            <div class="plan-card {{ $plan->is_featured ? 'highlighted' : '' }}">
                                @if($plan->is_featured)
                                    <span class="highlight-badge">Most Popular</span>
                                @endif
                                
                                <h3>{{ $plan->name }}</h3>
                                <div class="plan-price">
                                    @if($plan->price > 0)
                                        ${{ number_format($plan->price, 2) }}
                                        <span class="price-period">/ {{ $plan->plan_duration < 12 ? $plan->plan_duration.' month' : ($plan->plan_duration/12).' year' }}</span>
                                    @else
                                        ${{ number_format($plan->price, 2) }}<span class="price-period"> / unlimited</span>
                                    @endif
                                </div>
                                
                                @if($plan->free_trial_days > 0)
                                    <p class="free-demo">
                                        {{ $plan->free_trial_days }} days free trial
                                    </p>
                                @endif
                                <div class="plan-features">
                                @php
                                    $decodedFeatured = [];
                                        if(is_array($plan->features) &&$plan->features[0]){
                                        $decodedFeatured = json_decode($plan->features[0]);
                                        }elseif(is_array($plan->features) ) {
                                        $decodedFeatured = json_decode($plan->features);
                                    } else{
                                        $decoded = json_decode($plan->features, true);
                                        if (json_last_error() === JSON_ERROR_NONE) {
                                            $decodedFeatured = $decoded;
                                        }
                                    }
                                @endphp
                                @foreach(  $decodedFeatured as $feature)
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>{{ $feature }}</span>
                                    </div>
                                @endforeach
                                </div>
                                @php
                                    $userSubscription = auth()->user()->subscriptions()
                                        ->where('plan_id', $plan->id)
                                        ->where('status', 'confirm')
                                        ->latest()
                                        ->first();
                                        
                                    $isActive = $userSubscription && 
                                            ($userSubscription->end_date === null || 
                                                $userSubscription->end_date->gt(now()));
                                                
                                    // Check if user has any active subscription (from controller)
                                    $disableSubscribe = $hasActiveSubscription && !$isActive;
                                @endphp
                                
                                @if($plan->price != 0)
                                    @if($userSubscription && $isActive)
                                        <span class="current-plan-badge">Current Plan</span>
                                        <div class="expiry-info">
                                            @if($userSubscription->end_date)
                                                Expires in {{ intval(now()->diffInDays($userSubscription->end_date)) }} days
                                            @else
                                                No expiration date
                                            @endif
                                        </div>
                                        <button class="btn-subscribe" disabled>Already Subscribed</button>
                                    @elseif($userSubscription && !$isActive)
                                        <form action="{{ route('publisher.subscriptions.renew', $plan) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-subscribe">
                                                Renew Subscription
                                            </button>
                                        </form>
                                        <div class="expiry-info">
                                            Expired {{ $userSubscription->end_date ? $userSubscription->end_date->diffForHumans() : '' }}
                                        </div>
                                    @else
                                        <form action="{{ route('publisher.subscriptions.subscribe', $plan) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-subscribe" {{ $disableSubscribe ? 'disabled' : '' }}>
                                                Subscribe Now
                                            </button>
                                            @if($disableSubscribe)
                                                <div class="expiry-info mt-2">
                                                    You already have an active subscription
                                                </div>
                                            @endif
                                        </form>
                                    @endif
                                @endif
                            </div>
                            @endforeach
                        </div>
</div>
@endsection