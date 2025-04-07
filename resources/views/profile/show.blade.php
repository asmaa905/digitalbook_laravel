@extends('layouts.user')
@section('user-title', 'Readed Books')


@section('user-styles')
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
@endsection

@section('user-content')
<div class="  py-5 " style= "   color: #101010;
background: #f8f6f5;">
        
  <div class="w-100  bg-black text-white">
<div class="account-container">
            <h1>My Account</h1>
            <h3 class="account-name">{{ auth()->user()->name }}</h3>
            <p class="account-email">{{ auth()->user()->email }}</p>
        </div>
    
  </div>
    
    <div class="account-sections px-5  mt-5"style=   " color: #101010;
    background: #f8f6f5;">
        <div class="account-sidebar">
            <a href="{{ route('profile.show') }}" class="account-menu-item active">
                <i class="fas fa-user"></i> Account
            </a>
            <a href="#" class="account-menu-item">
                <i class="fas fa-lock"></i> Security
            </a>
            <a href="{{ route('books.reader.index') }}" class="account-menu-item">
                <i class="fas fa-book"></i> My Reading History
            </a>
            @if(Auth::check() && Auth::user()->role === 'Publisher')
            <a href="{{ route('subscription.index') }}" class="account-menu-item">
                <i class="fas fa-credit-card"></i> Subscriptions
            </a>
            {{--"{{ route('payments.index') }}" --}}
            <a href="#" class="account-menu-item">
                <i class="fas fa-credit-card"></i> Payments
            </a>
            @endif
           
            <form method="POST" action="{{ route('logout') }}" class="account-menu-item">
                @csrf
                <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
        
        <div class="account-content">
            <h2 class="section-title">Account</h2>
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                
                <div class="form-group">
                    <label class="form-label" for="name">Full Name</label>
                    <input id="name" name="name" type="text" class="form-input" value="{{ old('name', auth()->user()->name) }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="phone">Phone Number</label>
                    <input id="phone" name="phone" type="tel" class="form-input" value="{{ old('phone', auth()->user()->phone) }}">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="image">Profile Picture</label>
                    <input id="image" name="image" type="file" class="form-input">
                </div>
                
                <button type="submit" class="btn-primary">Save Changes</button>
            </form>
            
            <div class="danger-zone">
                <h3 class="danger-title">Danger Zone</h3>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn-primary" style="background-color: #f44336;">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>

    </div>
 </div>
@endsection
