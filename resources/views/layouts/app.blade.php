<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Listen To Story - @yield('title')</title>
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
      <!-- Bootstrap CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        />
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/navbar.css')}}" />

        @yield('styles')
    </head>
    <body>
    <nav class="navbar navbar-expand-lg py-0" style="background-color: rgb(16, 16, 16)">
    <div class="cont">
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
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"> Categories </a>
                </li>
            </ul>
            <ul class="navbar-nav sMspI" style="padding-left: 20px">
                <li class="nav-item active">
                    <a class="nav-link" class="btn bg-none text-white" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="gqCvyq" href="{{ route('register') }}" class="btn bg-white text-black">
                        Get Started
                    </a>
                </li>
            </ul>

            <button class="btn my-2 my-sm-0" style="padding-left: 32px">
                <i class="fa-solid fa-magnifying-glass text-white"></i>
            </button>
        </div>
    </div>
</nav>


        <!-- <div class="container mt-4"> -->
            @yield('content') <!-- Correct way to include page content -->
        <!-- </div> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script> -->

        @yield('scripts')
    </body>
</html>
