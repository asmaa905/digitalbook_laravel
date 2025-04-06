@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">Reset Password</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-warning w-100">Send Password Reset Link</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection