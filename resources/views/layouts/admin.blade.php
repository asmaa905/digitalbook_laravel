@extends('layouts.app')

@section('title')
  @yield('admin-title')
@endsection

@section('styles')
  @yield('admin-styles')
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/navbaradmin.css')}}" />
  <link href="{{asset('assets/css/navigation-pagination.css')}}" rel="stylesheet">
  @endsection


@section('content')
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-light text-dark" style="background: linear-gradient(to bottom right, #f8f9fa 0%, #eff0f1 100%);z-index: 999; width: 250px; min-height: 100vh;">
                <div class=""style="padding-top: 1rem !important;padding-bottom: 1.15rem !important;background-color:#ddd">
                    <h4 class="text-center mb-0">
                        <a href="{{route('user.home')}}" class="text-dark" style="text-decoration-line:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" fill="#FF5C28" viewBox="0 0 21 24">
                                <path d="M20.466 11.109c.876-4.8-2.049-9.093-6.627-10.519C5.709-1.94-.052 5.506.014 13.015c.053 6.066 1.354 10.098 1.354 10.101-.058-.18 1.536-1.02 1.72-1.114.625-.32 1.28-.582 1.944-.802 1.372-.456 2.79-.743 4.197-1.064 4.399-1.006 9.127-2.902 10.81-7.47.19-.515.33-1.036.427-1.557Z"></path>
                            </svg>
                            <span style="color: #000; font-weight: bold">Listen To Story</span>
                        </a>
                    </h4>
                </div>
              <div class=" py-4 px-3"style="padding-bottom: 1.5rem !important;">
                <ul class="nav flex-column" style="margin-top:5px;">
                    <li class="nav-item @if(request()->routeIs('admin.dashboard')) bg-dark @else bg-custom-light @endif" style="border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link @if(request()->routeIs('admin.dashboard')) text-white @else text-dark @endif" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.users.*')) bg-dark @else bg-custom-light @endif" style="border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link @if(request()->routeIs('admin.users.*')) text-white @else text-dark @endif" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-user-edit me-2"></i> Users
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.books.*')) bg-dark @else bg-custom-light @endif" style="border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link @if(request()->routeIs('admin.books.*')) text-white @else text-dark @endif" href="{{ route('admin.books.index') }}">
                            <i class="fas fa-book me-2"></i> Books
                        </a>
                    </li>
                    <li class="nav-item  @if(request()->routeIs('admin.audio-versions.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                         <a class="nav-link  @if(request()->routeIs('admin.audio-versions.*')) text-white @else text-dark @endif" href="{{ route('admin.audio-versions.index') }}">
                            <i class="fas fa-headphones me-2"></i> Audio Versions
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.authors.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.authors.*'))  text-white @else text-dark @endif" href="{{ route('admin.authors.index') }}">
                            <i class="fas fa-user-edit me-2"></i> Authors
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.publishing-houses.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.publishing-houses.*'))  text-white @else text-dark @endif" href="{{ route('admin.publishing-houses.index') }}">
                            <i class="fas fa-building me-2"></i> Publishing Houses
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.categories.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.categories.*'))  text-white @else text-dark @endif" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags me-2"></i> Categories
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.subscriptions.*')) bg-dark @else bg-custom-light @endif" style=" 
                       border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.subscriptions.*'))  text-white @else text-dark @endif" href="{{ route('admin.subscriptions.index') }}">
                        <i class="fa-solid fa-subscript  me-2"></i> Subscribtons
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.plans.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.plans.*'))  text-white @else text-dark @endif" href="{{ route('admin.plans.index') }}">
                            <i class="fas fa-list-alt me-2"></i> Plans
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.reviews.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.reviews.*'))  text-white @else text-dark @endif" href="{{ route('admin.reviews.index') }}">
                            <i class="fas fa-star me-2"></i> Reviews
                        </a>
                    </li>
                    <li class="nav-item @if(request()->routeIs('admin.payments.*')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5; margin-bottom: 5px;">
                        <a class="nav-link   @if(request()->routeIs('admin.payments.*'))  text-white @else text-dark @endif" href="{{ route('admin.payments.index') }}">
                            <i class="fas fa-credit-card me-2"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item mt-3  @if(request()->routeIs('admin.layout')) bg-dark @else bg-custom-light @endif" style="    border-radius:10px;border-bottom: 1px solid #e5e5e5;margin-bottom: 5px;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link   @if(request()->routeIs('admin.layout'))  text-white @else text-dark @endif border-0 w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg  text-dark shadow-sm" style="background-color:#ddd">
                <div class="container-fluid">
                    <span class="navbar-brand text-white">@yield('admin-nav-title')</span>
                    <div class="d-flex align-items-center g-2">
                    <ul class="navbar-nav" style="padding-left: 20px">
                            @if (Route::has('login'))
                                @auth
                                    <div class="sMspI">
                                        <li class="nav-item dropdown ">
                                            <a class="nav-link dropdown-toggle
                                                d-flex justify-content-center align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <div class="profile-icon">
                                                @if(auth()->user()->image)
                                                        <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile" class="profile-image">
                                                @else
                                                    <i class="fas fa-user-circle"style="font-size:17px">></i>
                                                @endif
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                                    <i class="fas fa-user me-2"></i> 
                                                    <span class="" >Profile</span>
                                                </a>
                                                <a class="dropdown-item" href="{{ route('user.home') }}">
                                                    <i class="fas fa-home me-2"></i> Home
                                                </a>
                                                @if(Auth::check() && Auth::user()->role === 'Reader')
                                                    <a class="dropdown-item" href="{{ route('books.reader.index') }}">
                                                        <i class="fa-solid fa-book"></i>Readed Books
                                                    </a>
                                            
                                                @elseif(Auth::check() && Auth::user()->role === 'Publisher')
                                                    <a class="dropdown-item " style="" href="{{ route('publisher.books.index') }}">
                                                        <i class="fa-solid fa-book"></i> My published books
                                                    </a>
                                                @elseif(Auth::check() && Auth::user()->role === 'Admin')
                                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                                    </a>
                                                @endif
                                                
                                                
                                                <div class="dropdown-divider"></div>
                                            
                                                <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    </div>
                                @endauth 
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4">  @yield('admin-content')
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
      @yield('admin-scripts')
    @endsection