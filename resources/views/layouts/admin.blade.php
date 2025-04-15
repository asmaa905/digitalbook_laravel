@extends('layouts.app')

@section('title')
  @yield('admin-title')
@endsection

@section('styles')
  @yield('admin-styles')
@endsection


@section('content')
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <div class="p-4">
                <h4 class="text-center mb-4">Admin Dashboard</h4>
                <div class="text-center mb-4 d-flex flex-column justify-content-center">
                @if(auth()->user()->image)
                            <div class="current-image me-1">
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                                    alt="Current Profile Image"
                                    class="rounded-circle" width="40" height="40" >
                            </div>
                        @else
                            <div class="current-image ">
                                <div class="account-avatar" style="background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user" style="font-size: 2rem; color: #666;"></i>
                                </div>
                            </div>
                        @endif
                    <h5 class="mt-2">{{ auth()->user()->name }}</h5>
                    <small>{{ auth()->user()->email }}</small>
                </div>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-user-edit me-2"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.books.index') }}">
                            <i class="fas fa-book me-2"></i> Books
                        </a>
                    </li>
                    <li class="nav-item">
                         <a class="nav-link text-white" href="{{ route('admin.audio-versions.index') }}">
                            <i class="fas fa-headphones me-2"></i> Audio Versions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.authors.index') }}">
                            <i class="fas fa-user-edit me-2"></i> Authors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.publishing-houses.index') }}">
                            <i class="fas fa-building me-2"></i> Publishing Houses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags me-2"></i> Categories
                        </a>
                    </li>
                    <!-- resources\views\Admin\subscribtons\index.blade.php -->
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.subscriptions.index') }}">
                        <i class="fa-solid fa-subscript  me-2"></i> Subscribtons
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.plans.index') }}">
                            <i class="fas fa-list-alt me-2"></i> Plans
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.reviews.index') }}">
                            <i class="fas fa-star me-2"></i> Reviews
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link text-white bg-transparent border-0 w-100 text-start">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <span class="navbar-brand">@yield('admin-nav-title')</span>
                    <div class="d-flex align-items-center g-2">
                        @if(auth()->user()->image)
                            <div class="current-image me-1">
                                <img src="{{ asset('storage/' . auth()->user()->image) }}" 
                                    alt="Current Profile Image"
                                    class="rounded-circle" width="40" height="40" >
                            </div>
                        @else
                            <div class="current-image ">
                                <div class="account-avatar" style="background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-user" style="font-size: 2rem; color: #666;"></i>
                                </div>
                            </div>
                        @endif
                        <span class="">{{ auth()->user()->name }}</span>
                          
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