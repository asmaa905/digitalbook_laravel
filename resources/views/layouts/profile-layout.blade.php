@extends('layouts.user')
@section('user-title')
  @yield('page-title')
@endsection

@section('user-styles')

<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/profile-layout.css')}}" />
@yield('page-styles')


@endsection
@section('user-content')
<div class="py-5" style= "color: #101010;background: #f8f6f5;"> 
  <div class="w-100  bg-black text-white">
    <div class="account-container">
        @yield('page-header-cont')
        
    </div>
  </div>
    
    <div class="account-sections px-5  mt-5"style=   " color: #101010;
    background: #f8f6f5;">
        <div class="account-sidebar">
            <a href="{{ route('profile.show') }}" class="account-menu-item active">
                <i class="fas fa-user"></i> Account
            </a>
         
            @if(Auth::check() && Auth::user()->role === 'Reader')
            <a href="{{ route('books.reader.index') }}" class="account-menu-item">
                <i class="fas fa-book"></i> My Readed Books
            </a>
            @endif
            @if(Auth::check() && Auth::user()->role === 'Publisher')
            <a href="{{ route('publisher.books.index') }}" class="account-menu-item">
                <i class="fas fa-book"></i> My Published Books 
                {{--when open Published Books  it show me publised books page with muli tabs include drafts , published with  create books button and create audio book button and
                     when press on it show create book form, reject books--}}
            </a>
            <a href="{{ route('subscription.index') }}" class="account-menu-item">
            <i class="fas fa-subscript"></i> Subscriptions
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
        @yield('page-content')
        </div>
    </div>      
</div>
@endsection
@section('user-scripts')
  @yield('page-scripts')

@endsection
