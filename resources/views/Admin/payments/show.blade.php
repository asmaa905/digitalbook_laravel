@extends('layouts.admin')

@section('admin-title',  'Payment #' . $payment->id)
@section('admin-nav-title', 'Payment #' . $payment->id)

@section('admin-content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Payment Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                            <p><strong>Invoice Reference:</strong> {{ $payment->invoice_reference }}</p>
                            <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Amount:</strong> ${{ number_format($payment->total_amount, 2) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="payment-status status-{{ $payment->status }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </p>
                            <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($payment->card_number)
                    <div class="mt-3">
                        <p><strong>Card:</strong> {{ $payment->card_number }}</p>
                    </div>
                    @endif
                    
                    @if($payment->auth_code)
                    <div class="mt-3">
                        <p><strong>Auth Code:</strong> {{ $payment->auth_code }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            @if($payment->subscription)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Subscription Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Plan:</strong> {{ $payment->subscription->plan->name }}</p>
                    <p><strong>Start Date:</strong> {{ $payment->subscription->start_date->format('M d, Y') }}</p>
                    <p><strong>End Date:</strong> 
                        {{ $payment->subscription->end_date ? $payment->subscription->end_date->format('M d, Y') : 'None' }}
                    </p>
                    <p><strong>Status:</strong> {{ ucfirst($payment->subscription->status) }}</p>
                </div>
            </div>
            @endif
        </div>
        
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">User Information</h5>
                </div>
                <div class="card-body">
                    @if($payment->user)
                        <div class="d-flex align-items-center mb-3">
                            @if($payment->user->image)
                                <img src="{{ asset('storage/' . $payment->user->image) }}" 
                                     class="rounded-circle me-3" width="60" height="60">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h6>{{ $payment->user->name }}</h6>
                                <small class="text-muted">{{ $payment->user->email }}</small>
                            </div>
                        </div>
                        
                        <p><strong>User Since:</strong> {{ $payment->user->created_at->format('M d, Y') }}</p>
                        
                        <a href="{{ route('admin.users.show', $payment->user) }}" 
                            class="btn btn-sm btn-outline-primary mt-2">
                                View User Profile
                            </a>
                    @else
                        <p class="text-muted">User account deleted</p>
                    @endif
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Actions</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 mb-2"
                                onclick="return confirm('Are you sure you want to delete this payment?')">
                            <i class="fas fa-trash me-2"></i> Delete Payment
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-arrow-left me-2"></i> Back to Payments
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection