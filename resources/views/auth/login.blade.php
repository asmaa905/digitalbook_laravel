@extends('layouts.app')
@section('title')
Login
@endsection
@section('styles')
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
    .background-page {
        position: relative;
    }
    .login-form {
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

@section('content')
<div class="background-page" >
    <div class="bg-image">
        <img src="{{ asset('assets/images/login_hero.jpg') }}" alt="Background Image" class="img-fluid">
    </div>

    <div class="overlay">
        <div class="content">
                    <div
                        class="login-form"

                    >
                    <!--1 class="text-center">Login</h1>-->
                    <form  action="{{ route('login') }}" method="POST">
                    @csrf
                    
                                            
                    @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}">  -->

                        <div class="mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                          
                        <div class="mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter your password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button  type="submit" id="hidden-submit"  class="btn w-100 btn-orange" style="
                            display: inline-flex
;

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
                            transition: background-color 0.3s;">
                            Login
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <a
                            href="{{ route('register') }}"
                            class="text-decoration-none text-orange"
                            >Don't have an account? Register</a
                        >
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('multiStepForm');
        const steps = document.querySelectorAll('.form-step');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const progressBar = document.querySelector('.progress-bar');
        const accountTypeOptions = document.querySelectorAll('.account-type');
        const accountTypeInput = document.getElementById('account_type');
        const continueToStep3 = document.getElementById('continueToStep3');
        
        let currentStep = 0;
        
        // Update progress bar
        function updateProgress() {
            const progress = ((currentStep + 1) / steps.length) * 100;
            progressBar.style.width = `${progress}%`;
        }
        
        // Show current step and hide others
        function showStep(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
            });
            currentStep = stepIndex;
            updateProgress();
        }
        
        // Next button click handler
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Validate current step before proceeding
                if (currentStep === 0) {
                    // Validate step 1 fields
                    const requiredFields = form.querySelectorAll('#step1 [required]');
                    let isValid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                    
                    if (!isValid) return;
                }
                
                showStep(currentStep + 1);
            });
        });
        
        // Previous button click handler
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                showStep(currentStep - 1);
            });
        });
        
        // Account type selection
        accountTypeOptions.forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                accountTypeOptions.forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Set the account type value
                const selectedType = this.getAttribute('data-type');
                accountTypeInput.value = selectedType;
                
                // Enable continue button
                continueToStep3.disabled = false;
                
                // If publisher is selected, show step 3 next
                // If reader is selected, skip to submission
                if (selectedType === 'publisher') {
                    continueToStep3.textContent = 'Continue';
                } else {
                    continueToStep3.textContent = 'Complete Registration';
                }
            });
        });
        
        // Special handling for continue button on step 2
        continueToStep3.addEventListener('click', function() {
            if (accountTypeInput.value === 'publisher') {
                showStep(2); // Show publisher info form
            } else {
                document.getElementById('hidden-submit').click(); // Triggers normal form submission
            }
        });
//         continueToStep3.addEventListener('click', function() {
//     if (accountTypeInput.value === 'publisher') {
//         showStep(2);
//     } else {
//         document.getElementById('hidden-submit').click(); // Triggers normal form submission
//     }
// });
        // Initialize progress bar
        updateProgress();
        
        // If there are validation errors, show the appropriate step
        @if($errors->has('identity') || $errors->has('job_title') || $errors->has('publishing_house_id'))
            document.getElementById('account_type').value = 'publisher';
            showStep(2);
        @elseif($errors->has('account_type'))
            showStep(1);
        @endif
    });
</script>
@endsection