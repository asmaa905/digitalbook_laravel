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
                    <h4>Admin Registration</h4>
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

                    <form method="POST" action="{{ route('admin.register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">phone Number</label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Admin Registration Code</label>
                            <input type="text" name="admin_code" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image (optional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-danger w-100">Register</button>
                    </form>

                    <!-- Already Have an Account Link -->
                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account?</p>
                        <a href="{{ route('admin.login.create') }}" class="text-danger fw-bold">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
