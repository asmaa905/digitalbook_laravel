@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#28a745" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    <h3 class="text-success mb-3">Thank You, {{ $user->name }}!</h3>
                    <p class="lead">Your payment has been processed successfully.</p>
                    
                    <div class="payment-details mt-4">
                        <div class="row text-left">
                            <div class="col-md-6">
                            <p>We've sent a confirmation to: {{ auth()->user()->email }}</p>

                                <p><strong>Plan:</strong> {{ $subscription->plan->name }}</p>
                                <p><strong>Amount:</strong> EGP {{ number_format($payment->total_amount, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                                <p><strong>Invoice Reference:</strong> {{ $payment->invoice_reference }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <a href="{{ route('publisher.subscriptions.index') }}" class="btn btn-dark">
                            View My Subscription
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection