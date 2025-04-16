@extends('layouts.profile-layout')

@section('page-title', 'Subscription Details')
@section('page-header-cont')
<h1>Subscription Details</h1>
<h3 class="account-name">{{ $subscription->plan->name }} Plan</h3>
@endsection

@section('page-content')
<div class="container">
    <div class="card">
      
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Plan Details</h4>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th>Plan Name:</th>
                                <td>{{ $subscription->plan->name }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $subscription->status === 'confirm' ? 'success' : 'warning' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Start Date:</th>
                                <td>{{ $subscription->start_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>End Date:</th>
                                <td>{{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'No expiry' }}</td>
                            </tr>
                            <tr>
                                <th>Remaining Days:</th>
                                <td>
                                    @if($subscription->end_date)
                                        {{ intval(now()->diffInDays($subscription->end_date)) }} days
                                    @else
                                        Unlimited
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4>Payment Details</h4>
                    @if($subscription->payment)
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Transaction ID:</th>
                                    <td>{{ $subscription->payment->transaction_id }}</td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td>${{ number_format($subscription->payment->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Method:</th>
                                    <td>{{ ucfirst($subscription->payment->payment_method) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Date:</th>
                                    <td>{{ $subscription->payment->created_at->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Invoice Reference:</th>
                                    <td>{{ $subscription->payment->invoice_reference ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    @else
                        <p>No payment information available.</p>
                    @endif
                </div>
            </div>
            
            <div class="mt-4">
                <h4>Plan Features</h4>
                <ul class="list-group">

                   @foreach(json_decode($subscription->plan->features[0])  as $feature)
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="mt-4">
                <a href="{{ route('publisher.subscriptions.index') }}" class="btn btn-secondary">
                    Back to Subscriptions
                </a>
                @if($subscription->end_date && $subscription->end_date->lt(now()))
                    <form action="{{ route('publisher.subscriptions.renew', $subscription->plan) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Renew Subscription
                        </button>
                    </form>
                @endif
                @if($subscription->end_date && $subscription->end_date->gt(now()))
                <form action="{{ route('publisher.subscriptions.cancel', $subscription) }}" method="POST" class="d-inline">
                    @csrf
                    @method('POST')
                    <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to cancel this subscription?')">
                        Cancel Subscription
                    </button>
                </form>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection