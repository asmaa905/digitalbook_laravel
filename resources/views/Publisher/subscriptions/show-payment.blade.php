@extends('layouts.profile-layout')

@section('page-title', 'Payment Details')
@section('page-header-cont')
<h1>Payment Details</h1>
<h3 class="account-name">Transaction #{{ $payment->transaction_id }}</h3>
@endsection

@section('page-content')
<div class="container">
    <div class="card">
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Transaction Details</h4>
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th>Transaction ID:</th>
                                <td>{{ $payment->transaction_id }}</td>
                            </tr>
                            <tr>
                                <th>Date:</th>
                                <td>{{ $payment->created_at->format('M d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : 'danger' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td>EGP {{ number_format($payment->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
               {{--<div class="col-md-6">
                    <h4>Subscription Details</h4>
                    @if($payment->subscription)
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Plan:</th>
                                    <td>{{ $payment->subscription->plan->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Subscription Period:</th>
                                    <td>
                                        @if($payment->subscription->end_date)
                                            {{ $payment->subscription->start_date->format('M d, Y') }} - 
                                            {{ $payment->subscription->end_date->format('M d, Y') }}
                                        @else
                                            {{ $payment->subscription->start_date->format('M d, Y') }} - No expiry
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Invoice Reference:</th>
                                    <td>{{ $payment->invoice_reference ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    @else
                        <p>No associated subscription found.</p>
                    @endif
                </div>--}} 
            </div>
            
            <div class="mt-4">
                <a href="{{ route('publisher.subscriptions.payments') }}" class="btn btn-secondary">
                    Back to Payments
                </a>
               {{-- @if($payment->invoice_reference)
                    <a href="{{ route('publisher.payments.download', $payment) }}" class="btn btn-primary">
                        Download Invoice
                    </a>
                    <button onclick="window.print()" class="btn btn-outline-primary">
                        Print Receipt
                    </button>
                @endif--}}
            </div>
        </div>
    </div>
</div>
@endsection