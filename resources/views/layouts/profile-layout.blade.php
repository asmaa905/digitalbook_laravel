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
            <a href="{{ route('profile.show') }}" class="account-menu-item   @if(request()->routeIs('profile.show')) text-orange @else text-custom-dark @endif ">
                <i class="fas fa-user"></i> Account
            </a>
         
            @if(Auth::check() && Auth::user()->role === 'Reader')
            <a href="{{ route('books.reader.index') }}" class="account-menu-item   @if(request()->routeIs('books.reader.index')) text-orange @else text-custom-dark @endif ">
                <i class="fas fa-book"></i> My Readed Books
            </a>
            @endif
            @if(Auth::check() && Auth::user()->role === 'Publisher')
            <a href="{{ route('publisher.books.index') }}" class="account-menu-item   @if(request()->routeIs('publisher.books.index')) text-orange @else text-custom-dark @endif ">
                <i class="fas fa-book"></i> My Published Books 

            </a>
            <a href="{{ route('publisher.subscriptions.index') }}" class="account-menu-item   @if(request()->routeIs('publisher.subscriptions.index')) text-orange @else text-custom-dark @endif ">
            <i class="fas fa-subscript"></i> Subscriptions
            </a>
            <a href="{{ route('publisher.subscriptions.plans') }}" class="account-menu-item   @if(request()->routeIs('publisher.subscriptions.plans')) text-orange @else text-custom-dark @endif ">
            <i class="fas fa-table-list"></i> plans
            </a>
            {{--"" --}}
            <a href="{{ route('publisher.subscriptions.payments') }}#" class="account-menu-item   @if(request()->routeIs('publisher.subscriptions.payments')) text-orange @else text-custom-dark @endif ">
                <i class="fas fa-credit-card"></i> Payments
            </a>
            @endif
           
            <form method="POST" action="{{ route('logout') }}" class="account-menu-item " >
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
