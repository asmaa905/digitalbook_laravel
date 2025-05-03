@extends('layouts.admin')

@section('admin-title', 'Payments Management')

@section('admin-styles')
<style>
    .payment-status {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    .status-paid {
        background-color: #d4edda;
        color: #155724;
    }
    .status-failed {
        background-color: #f8d7da;
        color: #721c24;
    }
    .filter-container {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
        margin-bottom: 1.5rem;
    }

</style>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="filter-container">
      
        <strong>Payments</strong>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>
                                    @if($payment->user)
                                        {{ $payment->user->name }}
                                        <small class="text-muted d-block">{{ $payment->user->email }}</small>
                                    @else
                                        User deleted
                                    @endif
                                </td>
                                <td>${{ number_format($payment->total_amount, 2) }}</td>
                                <td>
                                    <span class="payment-status status-{{ $payment->status }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.payments.show', $payment) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.payments.destroy', $payment) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this payment?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No payments found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div>
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection