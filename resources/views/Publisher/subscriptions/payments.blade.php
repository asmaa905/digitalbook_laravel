@extends('layouts.profile-layout')

@section('page-title', 'My Payments')
@section('page-header-cont')
<h1>My Payments</h1>
<h3 class="account-name">My Payments History and Management</h3>
@endsection

@section('page-content')
<div class="container">
   
    <div class="card mt-4">
        <div class="card-header">
            <h3>Payment History</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Plan</th>
                            <th>Payment Method</th>
                            <th>Status</th>
                            <th>Invoice</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                <td>EGP {{ number_format($payment->total_amount, 2) }}</td>
                                <td>{{ $payment->subscription->plan->name ?? 'N/A' }}</td>
                                <td>{{ ucfirst($payment->payment_method) }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->status === 'paid' ? 'success' : 'danger' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($payment->invoice_reference)
                                        <a href="{{ route('publisher.subscriptions.payments.show', $payment) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No payment history found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection