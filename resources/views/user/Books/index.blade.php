@extends('layouts.user')

@section('user-title')
 @php
 if(book_type == 'ebooks') ebooks Collection
 else 
 audio books
@endsection

@section('user-styles')
<style>
    :root {
        --primary: #00a8e1;
        --secondary: #ff6b6b;
        --dark: #2c3e50;
        --light: #f8f9fa;
        --gray: #6c757d;
    }
    
    .ebooks-hero {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 4rem 0;
        margin-bottom: 3rem;
    }
    
    .ebook-card {
        border: none;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .ebook-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .ebook-cover {
        height: 200px;
        background-color: #f1f3f5;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .ebook-cover img {
        max-height: 100%;
        transition: transform 0.3s ease;
    }
    
    .ebook-card:hover .ebook-cover img {
        transform: scale(1.05);
    }
    
    .ebook-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--primary);
        color: white;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
    }
    
    .ebook-body {
        padding: 1.25rem;
    }
    
    .ebook-title {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .ebook-author {
        color: var(--gray);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .ebook-rating {
        color: #ffc107;
        font-size: 0.9rem;
    }
    
    .ebook-price {
        font-weight: bold;
        margin-top: 0.5rem;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary);
    }
    
    .ebook-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .btn-download {
        background-color: var(--primary);
        color: white;
        flex: 1;
    }
    
    .btn-preview {
        border: 1px solid var(--primary);
        color: var(--primary);
        flex: 1;
    }
    
    .ebooks-carousel {
        margin-bottom: 3rem;
    }
    
    .carousel-control-prev, .carousel-control-next {
        width: 5%;
    }
    
    @media (max-width: 767.98px) {
        .ebook-cover {
            height: 150px;
        }
        
        .ebooks-hero {
            padding: 2rem 0;
        }
    }
</style>
@endsection

@section('user-content')
<div class="ebooks-hero">
    <div class="container mt-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 mb-3">Discover Great Ebooks</h1>
                <p class="lead mb-4">Read your favorite books anytime, anywhere</p>
                <form class="ebook-search">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Search ebooks...">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            {{--<div class="col-lg-4 d-none d-lg-block">
                <img src="{{ asset('assets/images/banner-1.jpg') }}" alt="Ebooks" class="img-fluid">
            </div>--}}
        </div>
    </div>
</div>

<div class="container">
    <!-- Featured Ebooks -->
    <section class="mb-5">
        <h2 class="section-title">Featured Ebooks</h2>
        <div class="row">
            @foreach($books as $book)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="ebook-card">
                    <a href="{{ route('user.books.show', $book->id) }}" class="text-decoration-none">
                        <div class="ebook-cover">
                            <img src="{{asset('assets/images/banner-1.jpg') }}" alt="{{ $book->title }}">
                            <span class="ebook-badge">Featured</span>
                        </div>
                        <div class="ebook-body">
                            <h3 class="ebook-title">{{ $book->title }}</h3>
                            <p class="ebook-author">{{ $book->author->name ?? 'Unknown Author' }}</p>
                            <div class="ebook-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($book->rating ?? 0))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= ($book->rating ?? 0))
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <small>({{ $book->reviews_count ?? 0 }})</small>
                            </div>
                            <div class="ebook-price">${{ number_format($book->price, 2) }}</div>
                        </div>
                    </a>
                    <div class="ebook-actions">
                        {{--<a href="{{ $book->pdf_link }}" class="btn btn-sm btn-download" download>
                            <i class="fas fa-download"></i>
                        </a>--}}
                        @if($book->pdf_link !== null)
                        <a href="#" class="btn btn-sm btn-preview">
                          <i class="fas fa-glasses"></i>
                        </a>
                        @endif
                        @if($book->audioVersions->count() > 0)
                        <a href="#" class="btn btn-sm btn-preview">
                        <i class="fas fa-headphones"></i>
                        </a>
                        @endif

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Top Rated Ebooks -->
    <section class="mb-5">
        <h2 class="section-title">Top Rated</h2>
        <div class="row">
            @foreach($topRatedBooks as $book)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="ebook-card">
                    <a href="{{ route('user.books.show', $book->id) }}" class="text-decoration-none">
                        <div class="ebook-cover">
                            <img src="{{ asset('assets/images/default-ebook.jpg') }}" alt="{{ $book->title }}">
                            @if($book->rating >= 4)
                            <span class="ebook-badge">Top Rated</span>
                            @endif
                        </div>
                        <div class="ebook-body">
                            <h3 class="ebook-title">{{ $book->title }}</h3>
                            <p class="ebook-author">{{ $book->author->name ?? 'Unknown Author' }}</p>
                            <div class="ebook-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($book->rating ?? 0))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= ($book->rating ?? 0))
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="ebook-price">${{ number_format($book->price, 2) }}</div>
                        </div>
                    </a>
                    <div class="ebook-actions">
                    {{--<a href="{{ $book->pdf_link }}" class="btn btn-sm btn-download" download>
                            <i class="fas fa-download"></i>
                        </a>--}}
                        @if($book->pdf_link !== null)
                        <a href="#" class="btn btn-sm btn-preview">
                          <i class="fas fa-glasses"></i>
                        </a>
                        @endif
                        @if($book->audioVersions->count() > 0)
                        <a href="#" class="btn btn-sm btn-preview">
                        <i class="fas fa-headphones"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- New Releases -->
    <section class="mb-5">
        <h2 class="section-title">New Releases</h2>
        <div class="row">
           {{-- @foreach($newReleases as $book)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="ebook-card">
                    <a href="{{ route('user.books.show', $book->id) }}" class="text-decoration-none">
                        <div class="ebook-cover">
                            <img src="{{ asset('assets/images/default-ebook.jpg') }}" alt="{{ $book->title }}">
                            <span class="ebook-badge">New</span>
                        </div>
                        <div class="ebook-body">
                            <h3 class="ebook-title">{{ $book->title }}</h3>
                            <p class="ebook-author">{{ $book->author->name ?? 'Unknown Author' }}</p>
                            <div class="ebook-price">${{ number_format($book->price, 2) }}</div>
                        </div>
                    </a>
                    <div class="ebook-actions">
                   <a href="{{ $book->pdf_link }}" class="btn btn-sm btn-download" download>
                            <i class="fas fa-download"></i>
                        </a>
                        @if($book->pdf_link !== null)
                        <a href="#" class="btn btn-sm btn-preview">
                          <i class="fas fa-glasses"></i>
                        </a>
                        @endif
                        @if($book->audioVersions->count() > 0)
                        <a href="#" class="btn btn-sm btn-preview">
                        <i class="fas fa-headphones"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach --}}
        </div>
    </section>

    <!-- All Ebooks -->
    <section class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title mb-0">All Ebooks</h2>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                    Sort by: Title
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Title (A-Z)</a></li>
                    <li><a class="dropdown-item" href="#">Title (Z-A)</a></li>
                    <li><a class="dropdown-item" href="#">Price (Low to High)</a></li>
                    <li><a class="dropdown-item" href="#">Price (High to Low)</a></li>
                    <li><a class="dropdown-item" href="#">Rating</a></li>
                    <li><a class="dropdown-item" href="#">Newest</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            @foreach($books as $book)
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <div class="ebook-card">
                    <a href="{{ route('user.books.show', $book->id) }}" class="text-decoration-none">
                        <div class="ebook-cover">
                            <img src="{{ asset('assets/images/default-ebook.jpg') }}" alt="{{ $book->title }}">
                        </div>
                        <div class="ebook-body">
                            <h3 class="ebook-title">{{ $book->title }}</h3>
                            <p class="ebook-author">{{ $book->author->name ?? 'Unknown Author' }}</p>
                            <div class="ebook-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($book->rating ?? 0))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= ($book->rating ?? 0))
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <div class="ebook-price">${{ number_format($book->price, 2) }}</div>
                        </div>
                    </a>
                    <div class="ebook-actions">
                       {{--<a href="{{ $book->pdf_link }}" class="btn btn-sm btn-download" download>
                            <i class="fas fa-download"></i>
                        </a>--}}
                        @if($book->pdf_link !== null)
                        <a href="#" class="btn btn-sm btn-preview">
                          <i class="fas fa-glasses"></i>
                        </a>
                        @endif
                        @if($book->audioVersions->count() > 0)
                        <a href="#" class="btn btn-sm btn-preview">
                        <i class="fas fa-headphones"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        {{--<div class="d-flex justify-content-center mt-4">
            {{ $books->links() }}
        </div>--}}
    </section>
</div>

<!-- Preview Modals -->
@foreach($books as $book)
<div class="modal fade" id="previewModal-{{ $book->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview: {{ $book->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('assets/images/default-ebook.jpg') }}" class="img-fluid mb-3" alt="{{ $book->title }}">
                        <div class="d-grid gap-2">
                        {{--<a href="{{ $book->pdf_link }}" class="btn btn-sm btn-download" download>
                            <i class="fas fa-download"></i>
                        </a>--}}
                        @if($book->pdf_link !== null)
                        <a href="#" class="btn btn-sm btn-preview">
                          <i class="fas fa-glasses"></i>
                        </a>
                        @endif
                        @if($book->audioVersions->count() > 0)
                        <a href="#" class="btn btn-sm btn-preview">
                        <i class="fas fa-headphones"></i>
                        </a>
                        @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $book->title }}</h4>
                        <p class="text-muted">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                        <div class="mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($book->rating ?? 0))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= ($book->rating ?? 0))
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="ms-2">({{ $book->reviews_count ?? 0 }} reviews)</span>
                        </div>
                        <p>{{ $book->description }}</p>
                        <div class="mt-3">
                            <h6>Details</h6>
                            <ul class="list-unstyled">
                                <li><strong>Category:</strong> {{ $book->category->name ?? 'N/A' }}</li>
                                <li><strong>Published:</strong> {{ $book->publish_date->format('F Y') }}</li>
                                <li><strong>Pages:</strong> {{ $book->pages ?? 'N/A' }}</li>
                                <li><strong>Language:</strong> {{ $book->language ?? 'English' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('user-scripts')
<script>
    // Search functionality
    document.querySelector('.ebook-search input').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const ebookCards = document.querySelectorAll('.ebook-card');
        
        ebookCards.forEach(card => {
            const title = card.querySelector('.ebook-title').textContent.toLowerCase();
            const author = card.querySelector('.ebook-author').textContent.toLowerCase();
            
            if (title.includes(searchTerm) || author.includes(searchTerm)) {
                card.closest('.col-6').style.display = 'block';
            } else {
                card.closest('.col-6').style.display = 'none';
            }
        });
    });
    
    // Sort functionality
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('sortDropdown').textContent = 'Sort by: ' + this.textContent;
            // Implement actual sorting logic here
        });
    });
</script>
@endsection