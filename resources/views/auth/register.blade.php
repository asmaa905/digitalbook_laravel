@extends('layouts.user')
@section('user-title')
Register
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
    .regsiter-form {
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
</head>


@section('user-content')

<div class="background-page">
    <div class="bg-image">
        <img src="{{ asset('assets/images/login_hero.jpg') }}" alt="Background Image" class="img-fluid">
    </div>

    <div class="overlay">
        <div class="content">
            <div class="regsiter-form">
                <div class="progress-bar"></div>
                
                <!-- Step 1: Basic Registration -->
                <form id="multiStepForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="step1" class="form-step active">
                        <!-- <h3 class="text-center mb-4">Create Account</h3> -->
                        
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
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter your email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                                                
                        <div class="mb-3">
                            <label for="phone" class="form-label">  phone Number</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter your password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                                            <!-- Inside your form -->
                    <button type="submit" id="hidden-submit" style="display: none;"></button>
                        <button type="button" class="btn w-100 btn-orange next-step">
                            Continue
                        </button>
                    </div>
                    
                    <!-- Step 2: Account Type Selection -->
                    <div id="step2" class="form-step">
                        <h3 class="text-center mb-4">Select Account Type</h3>
                        <p class="text-center mb-4">Choose the type of account you want to create</p>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="account-type text-center" data-type="Reader">
                                    <i class="fas fa-book-reader"></i>
                                    <h4>Reader</h4>
                                    <p>Enjoy audiobooks and manage your library</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="account-type text-center" data-type="Publisher">
                                    <i class="fas fa-book-open"></i>
                                    <h4>Publisher</h4>
                                    <p>Publish and manage your audiobooks</p>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" id="account_type" name="account_type" value="{{ old('account_type') }}">
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step">Back</button>
                            <button type="button" id="continueToStep3" class="btn btn-orange next-step" disabled>Continue</button>
                        </div>
                    </div>
                    
                    <!-- Step 3: Publisher Information (only shown if publisher is selected) -->
                    <div id="step3" class="form-step">
                        <h3 class="text-center mb-4">Publisher Information</h3>
                        <p class="text-center mb-4">Please provide additional information for your publisher account</p>
                        
                        <div class="mb-3">
                            <label for="identity" class="form-label">Identity Document</label>
                            <input type="file" class="form-control @error('identity') is-invalid @enderror" name="identity" id="identity" value="{{ old('identity') }}">
                            <small class="text-muted">Upload a scanned copy of your ID or passport</small>
                            @error('identity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror" name="job_title" id="job_title" value="{{ old('job_title') }}">
                            @error('job_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="publishing_house_id" class="form-label">Publishing House (if applicable)</label>
                            <select class="form-control @error('publishing_house_id') is-invalid @enderror" name="publishing_house_id" id="publishing_house_id">
                                <option value="">Select Publishing House</option>
                                @foreach($publishingHouses as $house)
                                    <option value="{{ $house->id }}" {{ old('publishing_house_id') == $house->id ? 'selected' : '' }}>{{ $house->name }}</option>
                                @endforeach
                            </select>
                            @error('publishing_house_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step">Back</button>
                            <button type="submit" class="btn btn-orange">Complete Registration</button>
                        </div>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none text-orange">
                        already have account? Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('user-scripts')
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
                if (selectedType === 'Publisher') {
                    continueToStep3.textContent = 'Continue';
                } else {
                    continueToStep3.textContent = 'Complete Registration';
                }
            });
        });
        
        // Special handling for continue button on step 2
        continueToStep3.addEventListener('click', function() {
            if (accountTypeInput.value === 'Publisher') {
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
            document.getElementById('account_type').value = 'Publisher';
            showStep(2);
        @elseif($errors->has('account_type'))
            showStep(1);
        @endif
    });
</script>
@endsection