@extends('layouts.admin')

@section('admin-title', 'User Details: ' . $user->name)
@section('admin-nav-title', 'User Details')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">User Details: {{ $user->name }}</h5>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                @if($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" class="img-thumbnail" width="200">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 200px; height: 200px;">
                        <i class="fas fa-user fa-3x text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Full Name</label>
                            <div class="form-control-plaintext">{{ $user->name }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <div class="form-control-plaintext">{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Phone</label>
                            <div class="form-control-plaintext">{{ $user->phone }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Role</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-{{ $user->role === 'Admin' ? 'danger' : ($user->role === 'Publisher' ? 'primary' : 'success') }}">
                                    {{ $user->role }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Registered Date</label>
                    <div class="form-control-plaintext">{{ $user->created_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Publisher Information (shown only for publishers) -->
        @if($user->role === 'Publisher' && $user->publisher)
        <div class="border-top pt-4 mt-4">
            <h5 class="mb-4">Publisher Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">Job Title</label>
                        <div class="form-control-plaintext">{{ $user->publisher->job_title }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label text-muted">Publishing House</label>
                        <div class="form-control-plaintext">
                            {{ $user->publisher->publishingHouse->name ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            
            @if($user->publisher->identity)
            <div class="mb-3">
                <label class="form-label text-muted">Identity Document</label>
                <div>
                    <a href="{{ asset('storage/' . $user->publisher->identity) }}" 
                       target="_blank" 
                       class="btn btn-sm btn-outline-primary">
                        View Identity Document
                    </a>
                </div>
            </div>
            @endif
        </div>
        @endif

        <div class="mt-4 border-top pt-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to Users
            </a>
            
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger float-end" 
                        onclick="return confirm('Are you sure you want to delete this user?')">
                    <i class="fas fa-trash me-2"></i> Delete User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection