
@extends('layouts.user')

@section('user-title')
- categories Audio ooks and ebooks - {{$category->name}} 
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
        .single-cat-header .cat-head {
            font-weight: 600;
            font-style: normal;
            color: rgb(16, 16, 16) !important;
            font-size: 74px;
            line-height: 72px;
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
    <div class="main-sections">
        <div class="container p-0">
            <div class="single-cat-header py-5">
                <nav>
                    <ul class="sc-db0b2c15-0 lfjSpC">
                        <li
                            class="sc-e408b72-0 cJEgpJ sc-db0b2c15-1 gAVRKW"
                        >
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
                            <a
                                href="{{route('user.categories.index')}}"
                                style="
                                    text-decoration-line: none !important;
                                    text-decoration: none !important;
                                "
                                class="sc-e408b72-0 kAwrBF"
                                >Categories</a
                            >
                        </li>
                    </ul>
                </nav>
                <div class="cat-head">
                    <h1>{{$category->name}} </h1>
                </div>
            </div>
        <!-- filter by top rated -->
        <section class="books-section top-rated">
                <div class="row px-0 mx-0">
                    <div
                        class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                    >
                        <h3 class="sec-title">Top Rated</h3>
                        <div class="all-books-link d-flex">
                        <a style="text-decoration-line:none; color:#000" href="{{route('user.categories.topBooks',$category->id)}}"> View all titles</a>
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
                @if($topRatedBooks->count() > 0)
                @foreach($topRatedBooks as $book)
                    <div
                        class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                        style="border-radius: 5px"
                    >
                        <div class="image">
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
                            class="card-img-top"
                            />
                          
                        </div>

                        <div class="card-body p-0">
                            <h5 class="card-title pb-0 mb-0">
                             @if (strlen($book->title) > 25)
                                {{substr($book->title, 0, 25) . "..."}}
                             @else 
                               {{cutText($book->title)}} 
                            @endif
                               
                            </h5>
                            <p class="card-text pb-0 mb-0">
                            {{$book->author->name}}
                            </p>
                            <div
                                class="actions d-flex justify-content-between align-items-center"
                            >
                          
                                <div class="rates p-0">
                                    <img
                                        src="{{asset('assets/images/icons/star.svg')}}"
                                        alt=""
                                    />
                                    <span class="rate-avg"> {{$book->rating}} </span>
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

                                    @if($book->pdf_link)

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
                    </div>
                    @endforeach
                    @endif

                </div>
            </section>
        <!-- all books -->
        <section class="books-section all-books">
                <div class="row px-0 mx-0">
                    <div
                        class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                    >
                        <h3 class="sec-title">Explore the World of Books</h3>
                        <div class="all-books-link d-flex">
                        <a style="text-decoration-line:none; color:#000" href="{{route('user.categories.topBooks',$category->id)}}"> View all titles</a>
                        
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
                @if($category->books->count() > 0)
                @foreach($category->books as $book)
                    <div
                        class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                        style="border-radius: 5px"
                    >
                        <div class="image">
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
                            class="card-img-top"
                            />
                          
                        </div>

                        <div class="card-body p-0">
                            <h5 class="card-title pb-0 mb-0">
                             @if (strlen($book->title) > 25)
                                {{substr($book->title, 0, 25) . "..."}}
                             @else 
                               {{cutText($book->title)}} 
                            @endif
                               
                            </h5>
                            <p class="card-text pb-0 mb-0">
                            {{$book->author->name}}
                            </p>
                            <div
                                class="actions d-flex justify-content-between align-items-center"
                            >
                          
                                <div class="rates p-0">
                                    <img
                                        src="{{asset('assets/images/icons/star.svg')}}"
                                        alt=""
                                    />
                                    <span class="rate-avg"> {{$book->rating}} </span>
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

                                    @if($book->pdf_link)

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
                    </div>
                    @endforeach
                    @endif

                </div>
            </section>
        <!-- all featured books -->
        <section class="books-section featured-books">
                <div class="row px-0 mx-0">
                    <div
                        class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                    >
                        <h3 class="sec-title">Most Poplular</h3>
                        <div class="all-books-link d-flex">
                        <a style="text-decoration-line:none; color:#000" href="{{route('user.categories.topBooks',$category->id)}}"> View all titles</a>
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
                @if( $featuredBooks->count() > 0)
                @foreach( $featuredBooks as $book)
                    <div
                        class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                        style="border-radius: 5px"
                    >
                        <div class="image">
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
                            class="card-img-top"
                            />
                          
                        </div>

                        <div class="card-body p-0">
                            <h5 class="card-title pb-0 mb-0">
                             @if (strlen($book->title) > 25)
                                {{substr($book->title, 0, 25) . "..."}}
                             @else 
                               {{cutText($book->title)}} 
                            @endif
                               
                            </h5>
                            <p class="card-text pb-0 mb-0">
                            {{$book->author->name}}
                            </p>
                            <div
                                class="actions d-flex justify-content-between align-items-center"
                            >
                          
                                <div class="rates p-0">
                                    <img
                                        src="{{asset('assets/images/icons/star.svg')}}"
                                        alt=""
                                    />
                                    <span class="rate-avg"> {{$book->rating}} </span>
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

                                    @if($book->pdf_link)

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
                    </div>
                    @endforeach
                    @endif

                </div>
            </section>
        </div>
    </div>
@endsection


     

