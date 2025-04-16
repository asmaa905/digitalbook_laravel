@extends('layouts.profile-layout')
@section('page-title', 'My Account')


@section('page-styles')
<style>
    .account-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .account-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .account-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1.5rem;
        border: 2px solid #ff5c28;
    }
    
    .account-name {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    .account-email {
        color: #666;
        font-size: 1rem;
    }
    
    .account-sections {
        display: grid;
        grid-template-columns: 250px 1fr;
        gap: 2rem;
    }
    
    .account-sidebar {
        /* background: #fff; */
        border-radius: 8px;
        /* box-shadow: 0 2px 8px rgba(0,0,0,0.1); */
        padding: 1.5rem;
    }
    
    .account-menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        color: #333;
        text-decoration: none;
        border-bottom: 1px solid #eee;
        transition: all 0.2s;
    }
    
    .account-menu-item:hover {
        color: #ff5c28;
    }
    
    .account-menu-item i {
        margin-right: 0.75rem;
        width: 24px;
        text-align: center;
    }
    
    .account-menu-item.active {
        color: #ff5c28;
        font-weight: 600;
    }
    
    .account-content {
        /* background: #fff; */
        border-radius: 8px;
        /* box-shadow: 0 2px 8px rgba(0,0,0,0.1); */
        padding: 2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #555;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 1rem;
    }
    
    .btn-primary {
        background-color: #ff5c28;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background-color 0.2s;
    }
    
    .btn-primary:hover {
        background-color: #e04b20;
    }
    
    .danger-zone {
        border-top: 1px solid #ffebee;
        padding-top: 2rem;
        margin-top: 2rem;
    }
    
    .danger-title {
        color: #f44336;
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>
@section('page-header-cont')
<h1>My Account</h1>
<p class="account-name">Manage your account and update it</p>
@endsection
@section('page-content')
<div class="account-content">
    <h2 class="section-title">Account</h2>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">  
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @csrf
        @method('patch')
        
        <div class="form-group">
            <label class="form-label" for="name">Full Name</label>
            <input id="name" name="name" type="text" class="form-input" value="{{ old('name', auth()->user()->name) }}" required autofocus>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input id="email" name="email" type="text" class="form-input" value="{{ old('email', auth()->user()->email) }}" >
        </div>
        
        <div class="form-group">
            <label class="form-label" for="phone">Phone Number</label>
            <input id="phone" name="phone" type="tel" class="form-input" value="{{ old('phone', auth()->user()->phone) }}" >
        </div>
        
        <div class="form-group">
            <label class="form-label" for="image">Profile Picture</label>
            
            <!-- Current Profile Image Display -->
            @if(auth()->user()->image)
                <div class="current-image mb-3">
                    <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                         alt="Current Profile Image"
                         class="account-avatar"
                         style="display: block; margin-bottom: 10px;">
                    <p class="small text-muted">Current profile picture</p>
                </div>
            @else
                <div class="current-image mb-3">
                    <div class="account-avatar" style="background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-user" style="font-size: 2rem; color: #666;"></i>
                    </div>
                    <p class="small text-muted">No profile picture uploaded</p>
                </div>
            @endif
            
            <!-- File Input for New Image -->
            <input id="image" name="image" type="file" class="form-input">
            <small class="form-text text-muted">Upload a new image to replace your current profile picture (Max 2MB, JPG/PNG/GIF)</small>
        </div>

        <!-- Publisher-specific fields -->
        @if(auth()->user()->role === 'Publisher')
            <div class="publisher-fields mt-4">
                <h3 class="mb-3">Publisher Information</h3>
                
                <div class="form-group">
                    <label class="form-label" for="job_title">Job Title</label>
                    <input id="job_title" name="job_title" type="text" class="form-input" 
                           value="{{ old('job_title', auth()->user()->publisher->job_title ?? '') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="publishing_house_id">Publishing House</label>
                    <select id="publishing_house_id" name="publishing_house_id" class="form-input">
                        <option value="">-- Select Publishing House --</option>
                        @foreach(\App\Models\PublishingHouse::all() as $house)
                            <option value="{{ $house->id }}" 
                                {{ old('publishing_house_id', auth()->user()->publisher->publishing_house_id ?? '') == $house->id ? 'selected' : '' }}>
                                {{ $house->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="identity_document">Identity Document</label>
                    
                    @if(auth()->user()->publisher && auth()->user()->publisher->identity)
                        <div class="current-document mb-3">
                            <a href="{{ asset('storage/' . auth()->user()->publisher->identity) }}" 
                               target="_blank" class="btn btn-outline-primary">
                                View Current Document
                            </a>
                            <p class="small text-muted mt-1">Current identity document</p>
                        </div>
                    @endif
                    
                    <input id="identity_document" name="identity_document" type="file" class="form-input">
                    <small class="form-text text-muted">Upload identity document (PDF/JPG/PNG, Max 2MB)</small>
                </div>
            </div>
        @endif
        
        <button type="submit" class="btn-primary">Save Changes</button>
    </form>
</div>
@endsection
