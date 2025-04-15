@extends('layouts.profile-layout')

@section('page-title', 'My Subscriptions')
@section('page-header-cont')
<h1>My Subscriptions</h1>
<h3 class="account-name">Subscription History and Management</h3>
@endsection

@section('page-content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Active Subscriptions</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Days Remaining</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->plan->name }}</td>
                                <td>{{ $subscription->start_date->format('M d, Y') }}</td>
                                <td>{{ $subscription->end_date ? $subscription->end_date->format('M d, Y') : 'No expiry' }}</td>
                                <td>
                                    <span class="badge bg-{{ $subscription->status === 'confirm' ? 'success' : 'warning' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td>
                                @if($subscription->end_date)
                                        {{ intval(now()->diffInDays($subscription->end_date)) }} days
                                    @else
                                        Unlimited
                                    @endif
                                   Remaining
                                </td>
                                <td class="d-flex">
                                    @if($subscription->end_date && $subscription->end_date->lt(now()))
                                        <form action="{{ route('publisher.subscriptions.renew', $subscription->plan) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary">Renew</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Active</button>
                                    @endif
                                    <a href="{{ route('publisher.subscriptions.show', $subscription) }}" class="btn btn-sm btn-info">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No subscriptions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   
</div>
@endsection