@extends('layouts.admin')

@section('admin-title', 'Users Management')
@section('admin-nav-title', 'Users List')

@section('admin-styles')
<style>
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
@endsection

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Users</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add New User
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random' }}" 
                                     class="user-avatar" alt="{{ $user->name }}">
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                <span class="badge bg-{{ $user->role === 'Admin' ? 'danger' : ($user->role === 'Publisher' ? 'primary' : 'success') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    @if(($user->id === auth()->user()->id && $user->role === 'Admin') || ($user->role === 'Reader' || $user->role === 'Publisher'))
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($user->role === 'Reader' || $user->role === 'Publisher')
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection