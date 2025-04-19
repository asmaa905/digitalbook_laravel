@extends('layouts.user')

@section('user-title')
   Complete Registration
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
        <div class="content">
            <div class="social-register-form">
                <h3 class="text-center mb-4">Complete Registration</h3>
                <p class="text-center mb-4">Please provide additional information to complete your registration</p>
                
                <form action="{{ route('social.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3 text-center">
                        @if($socialUser['avatar'] ?? false)
                            <img src="{{ $socialUser['avatar'] }}" alt="Profile Image" class="rounded-circle mb-2" width="80" height="80">
                        @endif
                        <h5>{{ $socialUser['name'] }}</h5>
                        <small class="text-muted">{{ $socialUser['email'] }}</small>
                    </div>
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Account Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="readerRole" 
                                   value="Reader" {{ old('role', 'Reader') == 'Reader' ? 'checked' : '' }}>
                            <label class="form-check-label" for="readerRole">
                                Reader
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="publisherRole" 
                                   value="Publisher" {{ old('role') == 'Publisher' ? 'checked' : '' }}>
                            <label class="form-check-label" for="publisherRole">
                                Publisher
                            </label>
                        </div>
                        @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="publisherFields" style="display: {{ old('role') == 'Publisher' ? 'block' : 'none' }}">
                        <div class="mb-3">
                            <label for="identity" class="form-label">Identity Document</label>
                            <input type="file" class="form-control @error('identity') is-invalid @enderror" 
                                   name="identity" id="identity">
                            <small class="text-muted">Upload a scanned copy of your ID or passport (PDF only)</small>
                            @error('identity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror" 
                                   name="job_title" id="job_title" value="{{ old('job_title') }}">
                            @error('job_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="publishing_house_id" class="form-label">Publishing House (if applicable)</label>
                            <select class="form-control @error('publishing_house_id') is-invalid @enderror" 
                                    name="publishing_house_id" id="publishing_house_id">
                                <option value="">Select Publishing House</option>
                                @foreach($publishingHouses as $house)
                                    <option value="{{ $house->id }}" {{ old('publishing_house_id') == $house->id ? 'selected' : '' }}>
                                        {{ $house->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('publishing_house_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="submit" class="btn w-100 btn-orange">
                        Complete Registration
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('user-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const publisherFields = document.getElementById('publisherFields');
        const publisherRole = document.getElementById('publisherRole');
        const readerRole = document.getElementById('readerRole');
        
        // Show/hide publisher fields based on role selection
        function togglePublisherFields() {
            if (publisherRole.checked) {
                publisherFields.style.display = 'block';
                // Make publisher fields required
                document.getElementById('identity').required = true;
                document.getElementById('job_title').required = true;
            } else {
                publisherFields.style.display = 'none';
                // Remove required from publisher fields
                document.getElementById('identity').required = false;
                document.getElementById('job_title').required = false;
            }
        }
        
        // Initial toggle
        togglePublisherFields();
        
        // Add event listeners
        publisherRole.addEventListener('change', togglePublisherFields);
        readerRole.addEventListener('change', togglePublisherFields);
    });
</script>
@endsection