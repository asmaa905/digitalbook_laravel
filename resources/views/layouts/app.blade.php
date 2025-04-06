<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Listen To Story - @yield('title')</title>
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/navbar.css')}}" />
        @yield('styles')
    </head>
    <body>
    <nav class="navbar navbar-expand-lg py-0" style="background-color: rgb(16, 16, 16)">
        <div class="cont">
           {{--<a class="navbar-brand" href="{{ route('home') }}"> --}}
            <a class="navbar-brand" href="#">    
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="23" fill="#FF5C28" viewBox="0 0 21 24">
                    <path d="M20.466 11.109c.876-4.8-2.049-9.093-6.627-10.519C5.709-1.94-.052 5.506.014 13.015c.053 6.066 1.354 10.098 1.354 10.101-.058-.18 1.536-1.02 1.72-1.114.625-.32 1.28-.582 1.944-.802 1.372-.456 2.79-.743 4.197-1.064 4.399-1.006 9.127-2.902 10.81-7.47.19-.515.33-1.036.427-1.557Z"></path>
                </svg>
                <span style="color: #fff; font-weight: bold">Listen To Story</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav sMspI ms-auto" style="padding-left: 20px">
                    <li class="nav-item active">
                    <a class="nav-link" href="#">Audiobooks</a>

                        {{--<a class="nav-link" href="{{ route('audiobooks.index') }}">Audiobooks</a> --}}
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Categories</a>

                    {{--<a class="nav-link" href="{{ route('categories.index') }}">Categories</a>--}}
                    </li>
                </ul>
                
                <ul class="navbar-nav" style="padding-left: 20px">
                    @if (Route::has('login'))
                        @auth
                        <div class="sMspI">
                            <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle
                            d-flex justify-content-center align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-icon">
                                    <i class="fas fa-user-circle" style="font-size:17px"></i>
                                      {{--  @if(auth()->user()->image)
                                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile" class="profile-image">
                                        @else
                                            <i class="fas fa-user-circle"></i>
                                        @endif--}}
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        <i class="fas fa-user me-2"></i> My Profile
                                    </a>
                                    <a class="dropdown-item" href="{{ route('books.reader.index') }}">
                                    <i class="fa-solid fa-book"></i>Readed Books
                                    </a>
                                    <a class="dropdown-item" href="{{ route('books.reader.index') }}">
                                    <i class="fa-solid fa-headphones-simple"></i> Watched Books
                                    </a>
                                    <a class="dropdown-item" href="{{ route('books.publisher.index') }}">
                                    <i class="fa-solid fa-book"></i> My Published Books
                                    </a>
                                    <div class="dropdown-divider"></div>
                                   {{--
                                    <form method="POST" action="{{ route('logout') }}"> 
                                    --}}
                                    <form method="POST" action="#">
                                    @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </div>
                </ul>
                        @else
                <ul class="navbar-nav sMspI" style="padding-left: 20px">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="gqCvyq" href="{{ route('register') }}">
                                    Get Started
                                </a>
                            </li>
                        @endauth
                    @endif
                </ul>
                
                <button class="btn my-2 my-sm-0 search-btn" style="padding-left: 32px">
                    <i class="fa-solid fa-magnifying-glass text-white"></i>
                </button>
            </div>
        </div>
    </nav>
    @yield('content') 
    @yield('scripts')
    <!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <!-- <script src="../../js/app.js"></script> -->
    </body>
</html>