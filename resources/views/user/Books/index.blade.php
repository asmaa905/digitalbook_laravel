@extends('layouts.user')

@section('user-title')
@section('user-title')
@php
    if($book_type == 'ebook') 
        echo 'eBooks Collection';
    else 
        echo 'Audio Books Collection';
@endphp
@endsection
@endsection

@section('user-styles')
<style>
    body {
        font-family: "Euclid Circular A", sans-serif;
        background: rgb(255, 251, 250);
    }
    img,
    svg {
        vertical-align: unset;
    }
    @media (min-width: 992px) {
        .col-lg-12-8 {
            flex: 0 0 auto;
            width: calc(12.5% - 8px) !important;
        }
    }
    /* @media (min-width: 1200px) {
        .container,
        .container-lg,
        .container-md,
        .container-sm,
        .container-xl {
            max-width: 1297px;
        }
    } */
    @media (min-aspect-ratio: 4 / 5) {
        .jASifu {
            background-image: url(https://images.ctfassets.net/eukfsb1ndh2n/4zMIdOhEn4NazgHJVCq1IP/7cbbe41…/expiration_date_2026_11_20_kayla-bed-phone_16-9.jpg?fm=webp&w=1920);
        }
    }

    @media (min-aspect-ratio: 1 / 2) {
        .jASifu {
            @if($book_type == 'ebook')
              background-image: url(https://images.ctfassets.net/eukfsb1ndh2n/6uHy3wT7o0F05y5t0JrQ3N/26b40ed…/e-books_page_1080x1080_1_x_1_1080_x1080_.jpg?fm=webp&w=768);
            @else
              background-image: url(../../../../assets/images/banner-2.jpg);
            @endif
        }
    }
    .jASifu {
        display: flex;
        flex-direction: column;
        position: relative;
        width: 100%;
        background-repeat: no-repeat;
        background-size: cover;
        min-height: calc(100vh - 6.4rem);
        background-color: rgb(255, 242, 241);
        @if($book_type == 'ebook')
            background-image: url(../../../../assets/images/banner-1.jpg);
        @else
            background-image: url(../../../../assets/images/banner-2.jpg);
        @endif
        background-position: center center;     
          /* aspect-ratio: 1 / 1; */
    }
    @media screen and (min-width: 600px) {
        .cJhNxu {
            background-size: 100%;
            padding: 5.6rem 3.2rem 3.2rem;
        }
    }
    .cJhNxu {
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        grid-column: 2 / 3;
        grid-row-start: 2;
        margin-top: auto;
        padding: 5.6rem 1.6rem 3.2rem;
        background-image: linear-gradient(
            rgba(16, 16, 16, 0) 0%,
            rgb(16, 16, 16) 66.37%
        );
        background-size: 100%;
    }
    .content {
        padding: 0 0 50px 16px;
    }
    .main-title {
        font-style: normal;
        font-weight: 600;
        color: rgb(255, 80, 28);
        font-size: 83px;
        line-height: 81px;

        letter-spacing: -1.328px;
        text-decoration: none;
    }
    .head-desc {
        font-style: normal;
        font-weight: 400;
        color: #fff;
        font-size: 20px;
        line-height: 28px;
        text-decoration: none;
    }
    .try-btn {
        min-width: 10ch;
        border-radius: 1000px;
        padding: 5px 16px;
        background-color: rgb(255, 255, 255);
        transition: all 0.3s;
        text-decoration: none;

        font-size:13px;
        line-height:16px;
        color:rgb(16,16,16);
        font-weight:600

    }

    .try-btn:hover {
        color: rgb(16, 16, 16) !important;
        background-color: rgb(242, 238, 235);
        transform: translateY(-1px);
    }

    ul li {
        text-decoration: none;
        list-style: none;
    }
    ul.lfjSpC {
        padding-top: 32px;
        padding-bottom: 27px;
        padding-left: 0.75rem;
    }
    ul.lfjSpC li a {
        font-weight: 500;
        font-style: normal;
        color: rgb(92, 92, 92) !important;
        font-size: 16px;
        line-height: 22px;
        transition: all 1s ease-in-out;
    }
    ul.lfjSpC li a:hover {
        color: rgb(198, 70, 27) !important;
    }
    .books-section {
        row-gap: 2.4rem;
        padding-top: 0px;
        padding-bottom: 4rem;
        background-color: rgb(255, 251, 250);
    }
    .sec-title {
        font-weight: 600;
        font-style: normal;
        color: rgb(16, 16, 16) !important;
        font-size: 26px;
        line-height: 32px;
    }
    .cards {
        gap: 8px;
    }
    .sec-title:hover {
        text-decoration-line: underline;
        cursor: pointer;
    }
    .all-books-link {
        font-weight: 600;
        font-style: normal;
        color: rgb(16, 16, 16) !important;
        font-size: 13px;
        line-height: 16px;
        transition: all 1s ease-in-out;
    }
    .all-books-link:hover {
        text-decoration-line: underline;
    }
    .all-books-link span {
        padding-right: 5px;
    }
    .book-card {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        gap: 0.5rem;
        border: 0.8px solid #ccc;
        width: 166.4px;
        height: 250px;

        border-radius: 4rem;
        padding: 8px;
    }
    .book-card .image {
        /* max-width: 16rem;
        max-height: 16rem;
        min-width: var(--min-width);
        min-height: var(--min-height);
        height: 100%;
        width: 100%; */
        aspect-ratio: 1 / 1;
    }
    .book-card .card-title {
        font-weight: 600;
        font-style: normal;
        color: rgb(16, 16, 16) !important;
        font-size: 13px;
        line-height: 16px;
        transition: all 1s ease-in-out;
    }
    .book-card .card-text {
        font-weight: 400;
        font-style: normal;
        color: rgb(92, 92, 92) !important;
        font-size: 13px;
        line-height: 16px;
        transition: all 1s ease-in-out;
    }
    .book-card .actions {
        padding-top: 25px;
    }
    .book-card .actions .rates {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .book-card .actions .rates,
    .book-card .actions .pdf-version,
    .book-card .actions .audio-version {
        width: 32px;
        height: 16px;
    }
    .book-card .actions .rates img,
    .book-card .actions .pdf-version img,
    .book-card .actions .audio-version img {
        width: 100%;
        height: 100%;
    }

    .book-card .actions .rate-avg {
        color: rgb(92, 92, 92) !important;
        font-size: 13px;
        line-height: 16px;
    }
</style>
@endsection

@section('user-content')
<div class="hero">
    <div class="sc-1c680e04-0 jASifu">
        <div class="cJhNxu">
            <h1 class="main-title">
                @if($book_type == 'ebook')
                    eBooks
                @else
                    Audio Books
                @endif
            </h1>
            <p class="head-desc">
                @if($book_type == 'ebook')
                    Get access to more than 250 000 + eBooks - new content is added daily. Start now. Read anytime, anywhere.
                @else
                    Discover our vast collection of audio books - new titles added regularly. Listen anytime, anywhere.
                @endif
            </p>
            <a class="try-btn" href="#"> Try it for free </a>
        </div>
    </div>
</div>

    <div class="main-sections">
            <div class="container p-0">
                <nav>
                    <ul class="sc-db0b2c15-0 lfjSpC">
                        <li class="sc-e408b72-0 cJEgpJ sc-db0b2c15-1 gAVRKW">
                            <a
                                href="{{route('user.home')}}"
                                class="sc-e408b72-0 kAwrBF"
                                >Home</a
                            >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="4"
                                height="7"
                                viewBox="0 0 5 8"
                                fill="#767676ff"
                            >
                                <path
                                    d="m1.144.864 2.681 2.663A.73.73 0 0 1 4.022 4a.702.702 0 0 1-.196.474L1.144 7.137a.67.67 0 0 1-.73.145C.163 7.178 0 6.971 0 6.682V1.337A.67.67 0 0 1 1.144.864Z"
                                ></path>
                            </svg>
                        </li>
                    </ul>
                </nav>
                <section class="books-section featured-books">
                    <div class="row px-0 mx-0">
                        <div
                            class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                        >
                            <h3 class="sec-title">Featured Books</h3>
                            <div class="all-books-link d-flex">
                                <span> View all titles</span>
                                <div
                                    class="icon"
                                    style="width: 1rem; height: 1rem"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="width: 100%; height: 100%"
                                        fill="#101010"
                                        viewBox="0 0 15 28"
                                        class="sc-dd917b06-0 bAuqWJ"
                                    >
                                        <path
                                            d="m2.895 1.126 11.35 11.846c.277.286.415.658.415 1.028s-.138.742-.415 1.028L2.895 26.874a1.483 1.483 0 0 1-2.101.045 1.48 1.48 0 0 1-.045-2.102l10.414-10.873L.751 3.184A1.48 1.48 0 0 1 .796 1.08a1.48 1.48 0 0 1 2.1.045Z"
                                        ></path>
                                    </svg>
                                </div>
                                <!-- <i class="fas fa-greater-than"></i> -->
                            </div>
                        </div>
                    </div>
                    <div class="cards row p-0 m-0">
                      @foreach($books as $book)

                      <a href="{{ route('user.books.show', $book->id) }}" 
                            class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6 text-decoration-none"
                            style="border-radius: 5px">
                        
                             
                        <div class="image" style="width:95%;height:60%">
                        @php
                            $storagePath = public_path('storage/' .$book->image);
                            $publicPath = public_path( 'assets/images/' . $book->image);
                            if (!empty($book->image) && file_exists($storagePath)) {
                                $imageUrl = asset('storage/' . $book->image);
                            } elseif (!empty($book->image) && file_exists($publicPath)) {
                                $imageUrl = asset( 'assets/images/' .$book->image);
                            }else {
                                $imageUrl =asset('assets/images/' .'books/book-1.jpg' );
                            }      
                        @endphp
                        <img
                                src="{{ $imageUrl }}"
                            alt="book"
                            class="card-img-top w-100 h-100"
                            /> </div>
                            <div class="card-body p-0 w-100">
                                <h5 class="card-title pb-0 mb-0">
                                @if (strlen($book->title) > 15)
                                    {{substr($book->title, 0, 15) . "..."}}
                                @else 
                                {{cutText($book->title)}} 
                                @endif
                                </h5>
                                <p class="card-text pb-0 mb-0">
                                {{ $book->author->name ?? 'Unknown Author' }}
                                </p>
                                <div
                                    class="actions d-flex justify-content-between align-items-center"
                                >
                                    <div class="rates p-0">
                                        <img
                                            src="{{asset('assets/images/icons/star.svg')}}"
                                            alt=""
                                        />
                                        <span class="rate-avg">{{$book->rating}}</span>
                                        <small>({{ $book->reviews_count ?? 0 }})</small>

                                    </div>
                                    <div
                                        class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                    >
                                      @if($book->audioVersions->count() > 0)

                                        <div class="audio-version">
                                            <img
                                                src="{{asset('assets/images/icons/headphones.svg')}}"
                                                alt=""
                                            />
                                        </div>
                                        @endif
                                        @if($book->pdf_link !== null)
                                        <div class="pdf-version">
                                            <img
                                                src="{{asset('assets/images/icons/glasses.svg')}}"
                                                alt=""
                                            />
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                       @endforeach

                </section>
                <section class="books-section world-books">
                    <div class="row px-0 mx-0">
                        <div
                            class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                        >
                            <h3 class="sec-title">Explore the World of Books                            </h3>
                            <div class="all-books-link d-flex">
                                <span> View all titles</span>
                                <div
                                    class="icon"
                                    style="width: 1rem; height: 1rem"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="width: 100%; height: 100%"
                                        fill="#101010"
                                        viewBox="0 0 15 28"
                                        class="sc-dd917b06-0 bAuqWJ"
                                    >
                                        <path
                                            d="m2.895 1.126 11.35 11.846c.277.286.415.658.415 1.028s-.138.742-.415 1.028L2.895 26.874a1.483 1.483 0 0 1-2.101.045 1.48 1.48 0 0 1-.045-2.102l10.414-10.873L.751 3.184A1.48 1.48 0 0 1 .796 1.08a1.48 1.48 0 0 1 2.1.045Z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cards row p-0 m-0">
                      @foreach($books as $book)

                      <a href="{{ route('user.books.show', $book->id) }}" 
                            class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6 text-decoration-none"
                            style="border-radius: 5px">
                        
                              
                        <div class="image" style="width:95%;height:60%">
                        @php
                            $storagePath = public_path('storage/' .$book->image);
                            $publicPath = public_path( 'assets/images/' . $book->image);
                            if (!empty($book->image) && file_exists($storagePath)) {
                                $imageUrl = asset('storage/' . $book->image);
                            } elseif (!empty($book->image) && file_exists($publicPath)) {
                                $imageUrl = asset( 'assets/images/' .$book->image);
                            }else {
                                $imageUrl =asset('assets/images/' .'books/book-1.jpg' );
                            }      
                        @endphp
                        <img
                                src="{{ $imageUrl }}"
                            alt="book"
                            class="card-img-top w-100 h-100"
                            />
                        </div>
                            <div class="card-body p-0 w-100">
                                <h5 class="card-title pb-0 mb-0">
                                @if (strlen($book->title) > 15)
                                    {{substr($book->title, 0, 15) . "..."}}
                                @else 
                                {{cutText($book->title)}} 
                                @endif
                                </h5>
                                <p class="card-text pb-0 mb-0">
                                {{ $book->author->name ?? 'Unknown Author' }}
                                </p>
                                <div
                                    class="actions d-flex justify-content-between align-items-center"
                                >
                                    <div class="rates p-0">
                                        <img
                                            src="{{asset('assets/images/icons/star.svg')}}"
                                            alt=""
                                        />
                                        <span class="rate-avg">{{$book->rating}}</span>
                                        <small>({{ $book->reviews_count ?? 0 }})</small>

                                    </div>
                                    <div
                                        class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                    >
                                      @if($book->audioVersions->count() > 0)

                                        <div class="audio-version">
                                            <img
                                                src="{{asset('assets/images/icons/headphones.svg')}}"
                                                alt=""
                                            />
                                        </div>
                                        @endif
                                        @if($book->pdf_link !== null)
                                        <div class="pdf-version">
                                            <img
                                                src="{{asset('assets/images/icons/glasses.svg')}}"
                                                alt=""
                                            />
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                       @endforeach

                </section>
                <section class="books-section top-rated">
                    <div class="row px-0 mx-0">
                        <div
                            class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                        >
                            <h3 class="sec-title">Top Rated</h3>
                            <div class="all-books-link d-flex">
                                <span> View all titles</span>
                                <div
                                    class="icon"
                                    style="width: 1rem; height: 1rem"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="width: 100%; height: 100%"
                                        fill="#101010"
                                        viewBox="0 0 15 28"
                                        class="sc-dd917b06-0 bAuqWJ"
                                    >
                                        <path
                                            d="m2.895 1.126 11.35 11.846c.277.286.415.658.415 1.028s-.138.742-.415 1.028L2.895 26.874a1.483 1.483 0 0 1-2.101.045 1.48 1.48 0 0 1-.045-2.102l10.414-10.873L.751 3.184A1.48 1.48 0 0 1 .796 1.08a1.48 1.48 0 0 1 2.1.045Z"
                                        ></path>
                                    </svg>
                                </div>
                                <!-- <i class="fas fa-greater-than"></i> -->
                            </div>
                        </div>
                    </div>
                    <div class="cards row p-0 m-0">
                      @foreach($topRatedBooks as $book)

                      <a href="{{ route('user.books.show', $book->id) }}" 
                            class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6 text-decoration-none"
                            style="border-radius: 5px">
                        
                             
                        <div class="image" style="width:95%;height:60%">
                        @php
                            $storagePath = public_path('storage/' .$book->image);
                            $publicPath = public_path( 'assets/images/' . $book->image);
                            if (!empty($book->image) && file_exists($storagePath)) {
                                $imageUrl = asset('storage/' . $book->image);
                            } elseif (!empty($book->image) && file_exists($publicPath)) {
                                $imageUrl = asset( 'assets/images/' .$book->image);
                            }else {
                                $imageUrl =asset('assets/images/' .'books/book-1.jpg' );
                            }      
                        @endphp
                        <img
                                src="{{ $imageUrl }}"
                            alt="book"
                            class="card-img-top w-100 h-100"
                            /></div>
                            <div class="card-body p-0 w-100">
                                <h5 class="card-title pb-0 mb-0">
                                @if (strlen($book->title) > 15)
                                    {{substr($book->title, 0, 15) . "..."}}
                                @else 
                                {{cutText($book->title)}} 
                                @endif
                                </h5>
                                <p class="card-text pb-0 mb-0">
                                {{ $book->author->name ?? 'Unknown Author' }}
                                </p>
                                <div
                                    class="actions d-flex justify-content-between align-items-center"
                                >
                                    <div class="rates p-0">
                                        <img
                                            src="{{asset('assets/images/icons/star.svg')}}"
                                            alt=""
                                        />
                                        <span class="rate-avg">{{$book->rating}}</span>
                                        {{--<small>({{ $book->reviews_count ?? 0 }})</small>--}}

                                    </div>
                                    <div
                                        class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                    >
                                      @if($book->audioVersions->count() > 0)

                                        <div class="audio-version">
                                            <img
                                                src="{{asset('assets/images/icons/headphones.svg')}}"
                                                alt=""
                                            />
                                        </div>
                                        @endif
                                        @if($book->pdf_link !== null)
                                        <div class="pdf-version">
                                            <img
                                                src="{{asset('assets/images/icons/glasses.svg')}}"
                                                alt=""
                                            />
                                        </div>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                       @endforeach

                </section>
            </div>
        </div>


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