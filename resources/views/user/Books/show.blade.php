@extends('layouts.user')

@section('user-content')
<div class="container py-5 ">
    <div class="row" style="padding-top: 106px;">
        <!-- Main Book Info -->
        <div class="col-md-8">
            <h1>{{ $book->title }}</h1>
            <div class="d-flex align-items-center mb-3">
                <div class="rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $averageRating)
                            <i class="fas fa-star text-warning"></i>
                        @elseif($i - 0.5 <= $averageRating)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-2">({{ $reviewCount }} reviews)</span>
                </div>
            </div>
            <!-- Language -->
            <p>
                <strong>Language:</strong> 
                {{ strtoupper($book->language) }} ({{ implode(', ', $availableFormats) }})
            </p>

            <!-- Available formats -->
            @if(count($availableFormats) > 0)
            <div class="formats mb-3">
                <strong>Available as:</strong>
                @foreach($availableFormats as $format)
                <span class="badge bg-primary">{{ $format }}</span>
                @endforeach
            </div>
            @endif
            <div class="mb-4">
                <p>By <a href="#">{{ $book->author->name }}</a></p>
                <p>Published by <a href="#">{{ $book->publisher->name }}</a> on {{ $book->publish_date }}</p>
                <p>Category: <a href="#">{{ $book->category->name }}</a></p>
                <p>Language: {{ $book->language }}</p>
            </div>

            <div class="book-cover mb-4">
                <img src="{{ asset('assets/images/default-book.jpg') }}" alt="{{ $book->title }}" class="img-fluid" style="max-height: 400px;">
            </div>

            <div class="book-description mb-5">
                <h3>Description</h3>
                <p>{{ $book->description }}</p>
            </div>

            <!-- Audio Versions -->
            @if($book->audioVersions->count() > 0)
            <div class="audio-versions mb-5">
                <h3>Audio Versions</h3>
                <div class="list-group">
                    @foreach($book->audioVersions as $audio)
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5>Version by {{ $audio->creator->name ?? 'Unknown' }}</h5>
                               {{--@if($audio->language)
                                <!-- Language -->

                                <span class="badge bg-secondary">{{ $audio->language }}</span>
                                @endif--}} 
                            </div>
                            <audio controls>
                                <source src="{{ $audio->audio_link }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Reviews Section -->
            <div class="reviews mb-5">
                <h3>Reviews</h3>
                @if($book->reviews->count() > 0)
                    @foreach($book->reviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5>{{ $review->user->name }}</h5>
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-muted small">{{ $review->created_at->format('M d, Y') }}</p>
                            <p>{{ $review->comment }}</p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p>No reviews yet. Be the first to review!</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Purchase Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="card-title">${{ number_format($book->price, 2) }}</h4>
                    @if($book->pdf_link)
                    <a href="{{ $book->pdf_link }}" class="btn btn-primary btn-block mb-2" download>
                        <i class="fas fa-download"></i> Download Ebook
                    </a>
                    @endif
                    @if($book->audioVersions->count() > 0)
                    <button class="btn btn-success btn-block mb-2">
                        <i class="fas fa-headphones"></i> Listen Sample
                    </button>
                    @endif
                    <button class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </div>

            <!-- Related Books -->
            @if($relatedBooks->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5>More in {{ $book->category->name }}</h5>
                </div>
                <div class="card-body">
                    @foreach($relatedBooks as $related)
                    <div class="mb-3">
                        <a href="{{ route('user.books.show', $related->id) }}" class="d-flex text-decoration-none text-dark">
                            <img src="{{ asset('assets/images/default-book.jpg') }}" alt="{{ $related->title }}" width="60" class="me-3">
                            <div>
                                <h6 class="mb-0">{{ Str::limit($related->title, 30) }}</h6>
                                <small class="text-muted">{{ $related->author->name }}</small>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Same Author Books -->
            @if($authorBooks->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5>More by {{ $book->author->name }}</h5>
                </div>
                <div class="card-body">
                    @foreach($authorBooks as $authorBook)
                    <div class="mb-3">
                        <a href="{{ route('user.books.show', $authorBook->id) }}" class="d-flex text-decoration-none text-dark">
                        {{--"{{ asset($authorBook->image ?? 'assets/images/default-book.jpg') }}--}} 
                        <img src="{{ asset('assets/images/default-book.jpg') }}" alt="{{ $authorBook->title }}" width="60" class="me-3">
                            <div>
                                <h6 class="mb-0">{{ Str::limit($authorBook->title, 30) }}</h6>
                                <small class="text-muted">{{ $authorBook->category->name }}</small>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection