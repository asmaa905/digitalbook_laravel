@extends('layouts.admin')

@section('admin-title')
   Subscribtions
@endsection
@section('admin-nav-title')
  Dashboard
@endsection

@section('admin-content')
<div class="container">
    <h2>All Subscriptions</h2>
    
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td>{{ $subscription->user->name }}</td>
                    <td>{{ $subscription->plan->name }}</td>
                    <td>{{ $subscription->start_date ?  \Carbon\Carbon::parse($subscription->start_date)->format('Y-m-d') : 'N/A'  }}</td>
                    <td>{{ $subscription->end_date ? \Carbon\Carbon::parse($subscription->end_date)->format('Y-m-d') : 'N/A' }}</td>                    <td>
                        <span class="badge bg-{{ $subscription->isActive() ? 'success' : 'secondary' }}">
                            {{ $subscription->isActive() ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                    <a href="{{ route('admin.subscriptions.show', $subscription) }}" class="btn btn-sm btn-info">View</a>                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $subscriptions->links('pagination::bootstrap-5') }}
</div>
@endsection