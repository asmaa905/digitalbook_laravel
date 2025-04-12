@extends('layouts.user')
@section('user-title')
  Admin Login - 
@endsection
@section('user-content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-danger text-white">
                    <h4>Admin Login</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Login</button>
                    </form>

                    <!-- Create Admin Account Link -->
                    <div class="text-center mt-3">
                        <p class="mb-0">Don't have an account?</p>
                        <a href="{{ route('admin.register') }}" class="text-danger fw-bold">Create Admin Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
