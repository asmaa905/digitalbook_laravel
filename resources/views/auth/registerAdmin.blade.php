@extends('layouts.user')
@section('user-title')
Admin Register -
@endsection
@section('user-styles')
<style>
    .btn-orange {
        color: #fff !important;
        background-color: #ff5c28 !important;
    }
    .text-orange {
        color: #ff5c28;
    }
    .btn-orange:hover {
        color: #ff5c28;
        background-color: #fff;
        border-color: #ff5c28;
    }
    .bg-orange{
        color: #fff !important;
        background-color: #ff5c28 !important;
    }
    /* New styles for multi-step form */
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
    }
    .account-type {
        cursor: pointer;
        border: 1px solid #ddd;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .account-type:hover {
        border-color: #ff5c28;
    }
    .account-type.selected {
        border-color: #ff5c28;
        background-color: rgba(255, 92, 40, 0.1);
    }
    .account-type i {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #ff5c28;
    }
    .progress-bar {
        height: 5px;
        background-color: #ff5c28;
        width: 0%;
        transition: width 0.3s;
        margin-bottom: 20px;
    }
    .background-page {
        position: relative;
        height: 1400px;
    }
    .overlay {
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
    }
    .regsiter-form {
        width: 600px;
        margin: auto;
        background-color: white;
        padding: 45px 30px;
        margin-top: 120px;
        border-radius: 4px;
        box-shadow: 0 0 18px 0 rgba(0, 0, 0, .35);
        box-sizing: border-box;
        position: relative;
    }
   
    
    .divider {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }
    .divider::before, .divider::after {
        content: "";
        flex: 1;
        border-bottom: 1px solid #ddd;
    }
    .divider-text {
        padding: 0 10px;
        color: #6c757d;
    }
</style>
@endsection


@section('user-content')

<div class="background-page">
    <div class="bg-image h-100 w-100">
        <img src="{{ asset('assets/images/login_hero.jpg') }}" alt="Background Image" class="h-100 w-100 d-block">
    </div>

    <div class="overlay">
        <div class="content" style="padding:100px">
    <div class="row justify-content-center my-5">
        <div class="col-md-6">
            <div class="card regsiter-form">
                
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

                     <!-- Google Login Button -->
                    <a href="{{route('google.admin.redirect')}}" style="
                        display: inline-flex;
                        justify-content: center;
                        align-items: center;
                        padding: 0.9rem 1rem;
                        min-width: 15rem;
                        max-width: 100%;
                        white-space: nowrap;
                        font: inherit;
                        font-weight: 600;
                        vertical-align: middle;
                        border: 0;
                        border-radius: 2.5rem;
                        overflow: visible;
                        cursor: pointer;
                        transition: background-color 0.3s;
                            margin-bottom: 18px;" 
                        class="mt-2 btn btn-info d-flex flex-row justify-content-between align-items-center py-2 px-5" 
                        >
                          <span>Continue with Google</span>
                          <i class="fa-brands fa-google bg-white p-2 " style="border-radius:50% !important"></i>
                    </a>
                    <div class="divider">
                        <span class="divider-text">OR</span>
                    </div>
                    
   
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

                        <button type="submit" class="btn btn-dark w-100">Register As Admin</button>
                    </form>

                    <!-- Already Have an Account Link -->
                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account?</p>
                        <a href="{{ route('admin.login.create') }}" class="text-dark fw-bold">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection
