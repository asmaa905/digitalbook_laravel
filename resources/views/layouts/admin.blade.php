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
                <div class="text-center mb-4">
                    <img src="{{ auth()->user()->image ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" 
                         class="rounded-circle" width="80" height="80" alt="Profile">
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
                    <div class="d-flex align-items-center">
                        <span class="me-3">{{ auth()->user()->role }}</span>
                        <img src="{{ auth()->user()->image ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=random' }}" 
                             class="rounded-circle" width="40" height="40" alt="Profile">
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4">  @yield('admin-content')
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
      @yield('user-scripts')
    @endsection
</body>
</html>