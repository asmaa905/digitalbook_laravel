
@extends('layouts.user')

@section('user-title', 'My Subscription')

@section('user-content')
<div class="bg-dark text-white py-4">

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{asset('assets/images/banner-1.jpg')}}" class="d-block w-100" alt="..." style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Welcome to Our Bookstore</h5>
                    <p>Explore a world of audiobooks, PDFs, and more!</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('assets/images/banner-2.jpg')}}"  class="d-block w-100" alt="..." style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Top Stories, Anytime</h5>
                    <p>Listen, Read, and Enjoy at Your Pace</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{asset('assets/images/banner-3.jpg')}}"  class="d-block w-100" alt="..." style="height: 400px; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Top Stories, Anytime</h5>
                    <p>Listen, Read, and Enjoy at Your Pace</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Subscription Section -->
    <div class="container text-center mb-5">
        <h2 class="mb-3">Unlock the Experience</h2>
        <p class="lead mb-4">Subscribe now to remove ads and access exclusive content</p>
        {{--{{ route('subscription.page') }}--}}
        <a href="#" class="btn btn-warning btn-lg">Subscribe Now</a>
    </div>

    <!-- Top Rated Books Section -->
    <div class="container mb-5">
        <h3 class="mb-4 border-bottom pb-2">📚 Top Rated Books</h3>
        <div class="row">
            @foreach($topRatedBooks as $book)
                <div class="col-md-3 mb-4">
                    <div class="card bg-secondary text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">Author: {{ $book->author->name ?? 'Unknown' }}</p>
                            <p class="card-text">Rating: {{ $book->rating ?? 'N/A' }}</p>
                            <p class="card-text">Audio: {{ $book->audioVersions ? 'Available' : 'Not Available' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- All Books Section -->
    <div class="container mb-5">
        <h3 class="mb-4 border-bottom pb-2">📖 All Books</h3>
        <div class="row">
            @foreach($allBooks as $book)
                <div class="col-md-3 mb-4">
                    <div class="card bg-dark border-light text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">Author: {{ $book->author->name ?? 'Unknown' }}</p>
                            <p class="card-text">Rating: {{ $book->rating ?? 'N/A' }}</p>
                            <p class="card-text">Audio: {{ $book->audioVersion ? 'Available' : 'Not Available' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
