@extends('layouts.user')

@section('user-title')
Admin  Registration
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
    .social-register-form {
        width: 400px;
        margin: auto;
        background-color: white;
        padding: 45px 30px;
        margin-top: 120px;
        border-radius: 4px;
        box-shadow: 0 0 18px 0 rgba(0, 0, 0, .35);
        box-sizing: border-box;
        position: relative;
    }
</style>
@endsection
@section('user-content')
<div class="background-page">
    <div class="bg-image">
        <img src="{{ asset('assets/images/login_hero.jpg') }}" alt="Background Image" class="img-fluid">
    </div>

    <div class="overlay">
        <div class="content" style="padding:100px">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card social-register-form">

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="text-center mb-4">
                                @if($socialAdmin['avatar'] ?? false)
                                    <img src="{{ $socialAdmin['avatar'] }}" alt="Profile Image" class="rounded-circle mb-2" width="80" height="80">
                                @endif
                                <h5>{{ $socialAdmin['name'] }}</h5>
                                <small class="text-muted">{{ $socialAdmin['email'] }}</small>
                            </div>

                            <form method="POST" action="{{ route('admin.social.register.submit') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Admin Registration Code</label>
                                    <input type="text" name="admin_code" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-dark w-100">Complete Admin Registration</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection