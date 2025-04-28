@extends('layouts.admin')

@section('admin-title')
    Subscription Details
@endsection


@section('admin-content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Subscription Details</h2>
            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-sm btn-secondary">Back to Subscriptions</a>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>User Information</h4>
                    <p><strong>Name:</strong> {{ $subscription->user->name }}</p>
                    <p><strong>Email:</strong> {{ $subscription->user->email }}</p>
                    <p><strong>Joined:</strong> {{ $subscription->user->created_at->format('M d, Y') }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Plan Information</h4>
                    <p><strong>Plan:</strong> {{ $subscription->plan->name }}</p>
                    <p><strong>Price:</strong> ${{ number_format($subscription->plan->price, 2) }}</p>
                    <p><strong>Book Limit:</strong> {{ $subscription->plan->book_limit ?? 'Unlimited' }}</p>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <h4>Subscription Details</h4>
                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $subscription->isActive() ? 'success' : 'secondary' }}">
                            {{ $subscription->isActive() ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    <p><strong>Start Date:</strong> {{ $subscription->start_date->format('M d, Y') }}</p>
                    <p><strong>End Date:</strong> {{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'N/A' }}</p>
                    <p><strong>Created At:</strong> {{ $subscription->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Payment Information</h4>
                    @if($subscription->payments->count() > 0)
                        @foreach($subscription->payments as $payment)
                            <div class="border p-2 mb-2">
                                <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                                <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
                                <p><strong>Date:</strong> {{ $payment->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endforeach
                    @else
                        <p>No payment records found</p>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection