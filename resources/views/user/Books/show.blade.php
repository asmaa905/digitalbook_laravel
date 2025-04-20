@extends('layouts.user')
@section('user-title')
 {{ $book->title}} - 
@endsection
@section('user-styles')
<link
    rel="stylesheet"
    type="text/css"
    media="screen"
    href="{{asset('assets/css/single-book.css')}}"
/>
<style>
    .audio-review audio {
        display: none;
    }
    .audio-review {
        cursor: pointer;
    }
    .review-form {
    background-color: #f8f9fa;
    border-radius: 8px;
    }

    .review-form h5 {
        margin-bottom: 20px;
        color: #333;
    }

    .star-rating {
        color: #ffc107;
        font-size: 1.2rem;
    }

    .comment-card {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .star-rating {
        display: inline-block;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .star-rating .star-icon {
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
        margin-right: 5px;
    }

    .star-rating .star-icon.selected,
    .star-rating .star-icon.hover {
        color: #212529;
    }

    .star-rating .star-icon.active {
        color: #ffc107;
    }
    .btn-fav:hover{
    background-color:rgb( 0 0 255/ 20%) !important;
    }
</style>
@endsection
@section('user-content')


<div class="main-sections">
            <div id="download-timer" style="z-index:9999;display:none;  background-color:rgba(0,0,0,0.6);margin-auto;text-align:center;height:2800px " 
            
            class=" w-100  position-absolute top-0 right-0 bottom-0 left-0">
                <div class="d-flex justify-content-center align-items-center flex-column ">
                    <p class="text-white w-25 mx-auto" style="padding: 349px 0 0;"><i class="fas fa-spinner"></i> 
                        Download will start in <span id="countdowndownload">10</span> seconds...
                    </p>
                </div>      
            </div>
            <div id="audios-timer" style="z-index:9999;display:none; background-color:rgba(0,0,0,0.6);margin-auto;text-align:center;height:2800px " class=" w-100  position-absolute top-0 right-0 bottom-0 left-0">
                <div class="d-flex justify-content-center align-items-center flex-column ">
                    <p class="text-white w-25 mx-auto" style="padding: 349px 0 0;"><i class="fas fa-spinner"></i>  
                        Audio will start in <span id="countdownaudio">10</span> seconds...
                    </p>
                </div>      
            </div>
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
                                    href="{{route('user.home')}}"
                                    style="
                                        text-decoration-line: none !important;
                                        text-decoration: none !important;
                                    "
                                    class="sc-e408b72-0 kAwrBF"
                                    >books</a
                                >
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="book-section row">
                    <div class="right-sec col-md-4">
                        <div class="image w-75 w-75">
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
                                class="w-100 h-100"
                                />
                         
                        </div>  
                          @if($book->audioVersions->count() > 0)
                        <div class="audio-review w-75 me-auto mt-2">
                            <div
                                class="d-flex justify-content-center align-items-center"
                            >
                                <div
                                    class="audio-icon"
                                    style="width: 13px; margin-right: 8px"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="img-fluid"
                                        fill="#101010ff"
                                        viewBox="0 0 32 32"
                                        class="sc-1f539a0b-25 iQRWTZ"
                                    >
                                        <path
                                            d="M26.825 13.56a2.867 2.867 0 0 1 1.37 2.442c0 .994-.519 1.917-1.37 2.387L9.68 28.867a2.747 2.747 0 0 1-2.888.107 2.859 2.859 0 0 1-1.46-2.494V5.524a2.859 2.859 0 0 1 4.348-2.439l17.144 10.476Z"
                                        ></path>
                                    </svg>
                                </div>
                            
                                <p class="text m-0">Sample</p>
                            </div>
                            @php
                                $storageAudio_reviewPath = public_path('storage/' .$book->audioVersions[0]->review_record_link);
                                $publicAudio_reviewPath = public_path('assets/images/' . $book->audioVersions[0]->review_record_link);
                                if (!empty($book->audioVersions[0]->review_record_link) && file_exists($storageAudio_reviewPath)) {
                                    $audio_reviewUrl = asset('storage/' . $book->audioVersions[0]->review_record_link);
                                } elseif (!empty($book->audioVersions[0]->review_record_link) && file_exists($publicAudio_reviewPath)) {
                                    $audio_reviewUrl = asset('assets/images/' .$book->audioVersions[0]->review_record_link);
                                } else {
                                    $audio_reviewUrl = asset('assets/images/books_audio_reviews/defualt.mp3');
                                }      
                            @endphp
                            <audio id="audio_review" src="{{$audio_reviewUrl}}"></audio>
                        </div>
                        @endif

                    </div>
                    <div class="left-sec col-md-8">
                        <div class="head">
                            <div class="d-flex justify-content-between align-items-center">
                                <h1>{{$book->title}}</h1>
                                @auth
                                    @if(auth()->user()->role !== 'Admin' && auth()->user()->role !== 'Publisher' && isset($book) && ($book->pdf_link || $book->audioVersions->count()))
                                    @php
                                        $isFav = auth()->user()->favBooks->contains($book->id);
                                    @endphp

                                    <form method="POST" action="{{ route('books.reader.makeFav', $book) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger rounded-sm px-2 py-1 btn-fav">
                                                <i class="{{ $isFav ? 'fas' : 'far' }} fa-heart mr-2 text-danger"></i>
                                            
                                        </button>
                                    </form>
                                    @endif
                                @endauth
                            </div>
                            
                            <div class="book-info d-flex">
                                <div class="author">
                                    By
                                    <a href="#">
                                    {{$book->author->name}}</a
                                    >
                                </div>
                                @foreach($book->audioVersions as $audio)

                                <div class="narior">
                                    With:
                                    <a href="#">
                                    {{$audio->creator->name}}</a
                                    >
                                </div>
                                @endforeach
                                <div class="publisher">
                                    Publisher<a
                                        href="#"
                                        >{{$book->publisher->name}}</a
                                    >
                                </div>
                            </div>
                            <div
                                class="book-audio-info row"
                                style="
                                    border-top: 1px solid #ccc;
                                    border-bottom: 1px solid #ccc;
                                "
                            >
                                <div
                                    class="audio-info-section col-md-2 d-flex flex-column justify-content-center align-items-center m-3"
                                    style="border-right: 1px solid #ccc"
                                >
                                    <div class="info-sec-title">
                                        <span class="rates-count">{{$book->reviews->count()}}</span>
                                        Ratings
                                    </div>
                                    <div class="info-sec-body d-flex">
                                        <div class="icon me-2">
                                      
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="value">{{$book->rating}}</div>
                                        <div
                                            class="icon"
                                            style="width: 1rem; height: 1rem"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                style="
                                                    width: 100%;
                                                    padding-left: 2px;
                                                    height: 100%;
                                                    padding-top: 4px;
                                                "
                                                fill="#5c5c5c"
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
                                <div
                                    class="audio-info-section col-md-2 d-flex flex-column justify-content-center align-items-center m-3"
                                    style="border-right: 1px solid #ccc"
                                >
                                    <div class="info-sec-title">Languages</div>
                                    <div class="info-sec-body d-flex">
                                        <div class="icon me-2">
                                            <i class="fas fa-earth"></i>
                                        </div>
                                        <div class="value">{{$book->language}}</div>
                                    </div>
                                </div>
                                <!-- <div
                                    class="audio-info-section col-md-2 d-flex flex-column justify-content-center align-items-center m-3"
                                    style="border-right: 1px solid #ccc"
                                >
                                    <div class="info-sec-title">Duration</div>
                                    <div class="info-sec-body d-flex">
                                        <div class="icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="value">1H 54Minutes</div>
                                    </div>
                                </div> -->
                                <div
                                    class="audio-info-section col-md-2 d-flex flex-column justify-content-center align-items-center m-3"
                                    style="border-right: 1px solid #ccc"
                                >
                                    <div class="info-sec-title">
                                        <!-- <span class="rates-count">576</span> -->
                                        Format
                                    </div>
                                    <div
                                        class="info-sec-body d-flex justify-content-end align-items-center"
                                    >
                                        @if($book->audioVersions->count() > 0) 
                                        <div class="icon me-2">
                                  
                                            <i
                                                class="fas fa-headphones-simple"
                                            ></i>
                                     
                                        </div>   @endif
                                        @if($book->pdf_link)

                                        <div class="icon">
                                            <i class="fas fa-glasses"></i>
                                        </div>
                                        @endif
                                      
                                    </div>
                                </div>

                                <div
                                    class="audio-info-section col-md-2 d-flex flex-column justify-content-center align-items-center m-3"
                                    style="border-right: 1px solid #ccc"
                                >
                                    <div class="info-sec-title">Categoy</div>
                                    <div class="info-sec-body d-flex">
                                        <div class="icon me-2">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="20"
                                                height="20"
                                                fill="#5c5c5cff"
                                                viewBox="0 0 18 16"
                                            >
                                                <path
                                                    d="M15.481.5c1.022 0 1.852.829 1.852 1.852v11.111c0 1.021-.83 1.852-1.852 1.852H8.074a1.854 1.854 0 0 1-1.852-1.852V2.352C6.222 1.329 7.052.5 8.074.5h7.407ZM3.444 2.583a.694.694 0 1 1 1.39 0v10.649c0 .384-.31.694-.695.694a.693.693 0 0 1-.695-.694V2.583ZM.667 3.973a.694.694 0 1 1 1.388 0v7.87a.694.694 0 1 1-1.388 0v-7.87Z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <div class="value">{{$book->category->name}}</div>
                                            <div
                                                class="icon"
                                                style="width: 1rem; height: 1rem"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    style="
                                                        width: 100%;
                                                        padding-left: 2px;
                                                        height: 100%;
                                                        padding-top: 4px;
                                                    "
                                                    fill="#5c5c5c"
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
                        </div>
                        <p class="desc">{{$book->description}}</p>
                        <div class="author-info">
                            <h5>About the author</h5>
                            <p>{{$book->author->name}}</p>
                        </div>
                        <div class="release-info">
                            <h5>Release Date</h5>

                            <p>Ebook: <span>{{$book->publish_date->format('M d, Y') }}</span></p>
                        </div>
                      
                        <div class="mt-2" id="existing-file-container">
                            <div class="d-flex align-items-center">
                                <div class="d-flex g-2" style="gap:5px">
                                    @if(isset($book) && $book->audioVersions->count())
                                        @if(( $book->publisher->role == 'Publisher' && $book->publisher->hasActiveSubscription))
                                            <!-- Immediate download for subscribed publishers -->
                                            <button id="audio-full-btn" class="btn btn-outline-dark">
                                                <i class="fas fa-music"></i> Watch all Audios
                                            </button>
                                            @else
                                                <!-- Timer for other users -->
                                                <button id="audio-full-btn" class="btn btn-outline-dark">
                                            <i class="fas fa-music"></i> Watch all Audio
                                        </button>
                                            @endif
                                    @endif
                                    @if(isset($book) && $book->pdf_link)
                                        @if(( $book->publisher->role == 'Publisher' && $book->publisher->hasActiveSubscription))
                                                <!-- Immediate download for subscribed publishers -->
                                                <a href="{{ asset('storage/'.$book->pdf_link) }}"   target="_blank" class="btn btn-dark rounded-sm" download="{{$book->title}}.pdf">
                                                    <i class="fas fa-file-pdf"></i> Download PDF
                                                </a>
                                                @else
                                                <!-- Timer for other users -->
                                                <button id="pdf-download-btn" class="btn btn-dark rounded-sm">
                                                    <i class="fas fa-file-pdf"></i> Download PDF
                                                </button>
                                            @endif
                                          
                                    @endif

                                    @auth
                                        @if(auth()->user()->role !== 'Admin' && auth()->user()->role !== 'Publisher' && isset($book) && ($book->pdf_link || $book->audioVersions->count()))
                                        @php
                                            $isReaded = auth()->user()->readedBooks && auth()->user()->readedBooks->contains($book->id);
                                        @endphp

                                        <form method="POST" action="{{ route('books.reader.markAsRead', $book) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-{{ $isReaded ? 'success' : 'outline-success' }}" {{ $isReaded ? 'disabled' : '' }}>
                                                <i class="fas fa-check mr-2"></i>
                                                {{ $isReaded ? 'Readed' : 'Mark as Readed' }}
                                            </button>
                                        </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <div class="all-audios mt-3" style="display:none">
                            @if(isset($book) && $book->audioVersions->count())
                                @foreach($book->audioVersions as $audioV)
                                    @php
                                        $storagePath = public_path('storage/' .$audioV->audio_link);
                                        $publicPath = public_path('assets/images/' . $audioV->audio_link);
                                        if (!empty($audioV->audio_link) && file_exists($storagePath)) {
                                            $audioUrl = asset('storage/' . $audioV->audio_link);
                                        } elseif (!empty($audioV->audio_link) && file_exists($publicPath)) {
                                            $audioUrl = asset('assets/images/' .$audioV->audio_link);
                                        } else {
                                            $audioUrl = asset('assets/images/books_audio_links/defualt.mp3');
                                        }      
                                    @endphp
                                    <div class="audio-item mb-3">
                                        <p>By: {{$audioV->creator->name}}</p>
                                        <audio controls style="width: 100%">
                                            <source src="{{ $audioUrl }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <section class="books-section more-by-autor pt-5">
                    <div class="row px-0 mx-0">
                        <div
                            class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                        >
                            <h3 class="sec-title">More by {{ $book->author?$book->author->name:'known' }}</h3>
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
                    <div class="cards row p-0 m-0 pt-2">
                    @if( $authorBooks->count() > 0)
                    @foreach($authorBooks as $authorBook)
                            <a
                                    class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                                    style="border-radius: 5px;text-decoration-line:none"
                                    href="{{ route('user.books.show', $authorBook->id) }}" 
                                >
                                    <div class="image"  style="width:95%;height:60%">
                                    @php
                                        $storagePath = public_path('storage/' .$authorBook->image);
                                        $publicPath = public_path( 'assets/images/' . $authorBook->image);
                                        if (!empty($authorBook->image) && file_exists($storagePath)) {
                                            $imageUrl = asset('storage/' . $authorBook->image);
                                        } elseif (!empty($authorBook->image) && file_exists($publicPath)) {
                                            $imageUrl = asset( 'assets/images/' .$authorBook->image);
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

                                    <div class="card-body p-0">
                                        <h5 class="card-title pb-0 mb-0">
                                        @if (strlen($authorBook->title) > 25)
                                            {{substr($authorBook->title, 0, 25) . "..."}}
                                        @else 
                                        {{cutText($authorBook->title)}} 
                                        @endif
                                        
                                        </h5>
                                        <p class="card-text pb-0 mb-0">
                                        {{$authorBook->author? $authorBook->author->name: 'unknown'}}
                                        </p>
                                        <div
                                            class="actions d-flex justify-content-between align-items-center"
                                        >
                                    
                                            <div class="rates p-0">
                                                <img
                                                    src="{{asset('assets/images/icons/star.svg')}}"
                                                    alt=""
                                                />
                                                <span class="rate-avg"> {{$authorBook->rating}} </span>
                                            </div>
                                            <div
                                                class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                            >

                                            @if($authorBook->audioVersions->count() > 0)

                                                <div class="audio-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/headphones.svg')}}"

                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                                @if($authorBook->pdf_link)

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
                            @endif
                    </div>
                </section>
                <section class="books-section more-by-cat pt-5">
                    <div class="row px-0 mx-0">
                        <div
                            class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                        >
                            <h3 class="sec-title">More by {{ $book->category?$book->category->name:'known' }}</h3>
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
                    <div class="cards row p-0 m-0 pt-2">
                    @if( $relatedBooks->count() > 0)
                        @foreach($relatedBooks as $relatedBook)
                            <a
                                    class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                                    style="border-radius: 5px;text-decoration-line:none"
                                    href="{{ route('user.books.show', $relatedBook->id) }}" 
                                >
                                <div class="image"  style="width:95%;height:60%">
                                    @php
                                        $storagePath = public_path('storage/' .$relatedBook->image);
                                        $publicPath = public_path( 'assets/images/' . $relatedBook->image);
                                        if (!empty($relatedBook->image) && file_exists($storagePath)) {
                                            $imageUrl = asset('storage/' . $relatedBook->image);
                                        } elseif (!empty($relatedBook->image) && file_exists($publicPath)) {
                                            $imageUrl = asset( 'assets/images/' .$relatedBook->image);
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
                                <div class="card-body p-0">
                                    <h5 class="card-title pb-0 mb-0">
                                    @if (strlen($relatedBook->title) > 25)
                                        {{substr($relatedBook->title, 0, 25) . "..."}}
                                    @else 
                                    {{cutText($relatedBook->title)}} 
                                    @endif
                                    
                                    </h5>
                                    <p class="card-text pb-0 mb-0">
                                    {{$relatedBook->author? $relatedBook->author->name: 'unknown'}}
                                    </p>
                                    <div
                                        class="actions d-flex justify-content-between align-items-center"
                                    >
                                        <div class="rates p-0">
                                            <img
                                                src="{{asset('assets/images/icons/star.svg')}}"
                                                alt=""
                                            />
                                            <span class="rate-avg"> {{$relatedBook->rating}} </span>
                                        </div>
                                        <div
                                            class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                        >
                                            @if($relatedBook->audioVersions->count() > 0)
                                                <div class="audio-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/headphones.svg')}}"
                                                        alt=""
                                                    />
                                                </div>
                                            @endif
                                            @if($relatedBook->pdf_link)
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
                    @endif
                    </div>
                </section>

                <section class="rating-review-section">
                    <div class="row px-0 mx-0">
                        <div class="sec-header col-md-12">
                            <h3 class="sec-title">Rating and reviews</h3>
                        </div>
                    </div>
                    <div
                        class="row justify-content-between"
                        style="gap: 1.6rem"
                    >
                        <div class="book-reviews col-sm-5 col-12">
                            <p>Reviews in brief.</p>
                            <div class="row justify-content-between">
                                <div class="book-img col-md-4 col-sm-4 col-6">
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
                                class="img-fluid"
                                />
                         
                                </div>
                                <div class="right-sec col-md-8 col-sm-8 col-6">
                                    <div class="review">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $averageRating)
                                            <i class="fas fa-star "></i>
                                        @elseif($i - 0.5 <= $averageRating)
                                            <i class="fas fa-star-half-alt "></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2">({{ $reviewCount }} reviews)</span>
                                    </div>
                                    <p>
                                        Overall rating based on
                                        <span>{{ $book->reviews->count() }} </span> ratings
                                    </p>
                                </div>
                            </div>
                        </div>
                        @auth 
                            @php
                            $isReaded = auth()->user()->readedBooks()->where('book_id', $book->id)->exists();
                            $userReview = $book->reviews->where('user_id', auth()->id())->first();
                            @endphp

                            @if(auth()->user()->role !== 'Admin' && auth()->user()->role !== 'Publisher' && $isReaded)                           
                                @if($userReview)
                                    <!-- Edit Review Form -->
                                    <div class="comment-card card mb-2"
                                style="
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                    padding-right: 20px;
                                    padding-left: 20px;
                                ">
                                        <h5>Edit Your Review</h5>
                                        <form method="POST" action="{{ route('user.review.update', $userReview) }}">
                                            @csrf
                                            @method('PUT')
                                            <div
                                    class="comment-sec-head d-flex justify-content-start"
                                >
                                    <div
                                        class="creator-img"
                                        style="
                                            border-radius: 50%;
                                            position: relative;
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            width: 56px;
                                            height: 56px;
                                            min-width: 56px;
                                            min-height: 56px;
                                            background-color: rgb(
                                                255,
                                                224,
                                                218
                                            );
                                            border-radius: 50%;
                                            background-size: cover;
                                            background-position: 50% center;
                                            background-repeat: no-repeat;
                                            margin-right: 20px;
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="width: 59%; height: 100%"
                                            fill="#5c5c5cff"
                                            viewBox="0 0 16 16"
                                        >
                                            <path
                                                d="M11.752 5.083c0 2.07-1.68 3.75-3.75 3.75-2.07 0-3.75-1.68-3.75-3.75 0-2.07 1.68-3.75 3.75-3.75 2.07 0 3.75 1.68 3.75 3.75Zm-1.25 0c0-1.377-1.123-2.5-2.5-2.5a2.504 2.504 0 0 0-2.5 2.5c0 1.378 1.123 2.5 2.5 2.5s2.5-1.122 2.5-2.5Z"
                                                clip-rule="evenodd"
                                            ></path>
                                            <path
                                                d="M7.998 10.515c-2.407 0-4.389 1.373-4.641 3.654-.03.274-.251.499-.527.499h-.163a.469.469 0 0 1-.479-.5c.256-2.936 2.759-4.816 5.81-4.816 3.053 0 5.557 1.88 5.813 4.816a.469.469 0 0 1-.479.5h-.163c-.276 0-.497-.225-.527-.5-.252-2.28-2.234-3.653-4.643-3.653Z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="rate-creator-info">
                                            <h6 class="creator-name">{{ auth()->user()->name }}</h6>
                                            <div
                                                class="rate-content d-flex justify-content-between"
                                            >
                                                <!-- <label for="rating-value"  class="form-label">Rating</label> -->
                                                <div class="star-rating">
                                                    <input type="hidden" name="rating" id="rating-value" value="{{ $userReview->rating }}" required>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star star-icon {{ $i <= $userReview->rating ? 'selected' : '' }}" 
                                                        data-value="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div> 
                                </div>
                                          
                                            
                                            <div class="mb-1">
                                                <!-- <label for="comment" class="form-label">Comment</label> -->
                                                <textarea class="form-control" name="comment" id="comment" rows="3" required>{{ $userReview->comment }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update Review</button>
                                            <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $userReview->id }})">Delete Review</button>
                                        </form>
                                        <form id="delete-form-{{ $userReview->id }}" method="POST" action="{{ route('user.review.destroy', $userReview) }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                @else
                                    <!-- Add Review Form -->
                                    <div class="review-form card p-4 mb-4 bg-white">
                                        <h5>Add Your Review</h5>
                                        <form method="POST" action="{{ route('user.review.store') }}">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            
                                            <!-- Star Rating Component -->
                                            <div class="mb-1">
                                                <!-- <label for="star-rating" class="form-label">Rating</label> -->
                                                <div class="star-rating">
                                                    <input type="hidden" name="rating" id="rating-value" value="0" required>
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="far fa-star star-icon" data-value="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <!-- <label for="comment" class="form-label">Comment</label> -->
                                                <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit Review</button>
                                        </form>
                                    </div>
                                @endif
                                @else
                                    <div class="alert alert-warning mt-3">
                                        You must read this book to submit a review.
                                    </div>
                                @endif
                        @endauth
                         @if($book->reviews->count() > 0)<div
                            class="comments d-flex flex-column justify-content-between col-sm-6 col-12"
                        >
                            <div
                                class="comments-head d-flex justify-content-between"
                            >
                                <p>Most popular reviews</p>
                                <p>Showing 10 from all reviews</p>
                            </div>

                       
                        @foreach($book->reviews as $review)
                            <div
                                class="comment-card card mb-2"
                                style="
                                    padding-top: 20px;
                                    padding-bottom: 20px;
                                    padding-right: 20px;
                                    padding-left: 20px;
                                "
                            >
                                <div
                                    class="comment-sec-head d-flex justify-content-start"
                                >
                                    <div
                                        class="creator-img"
                                        style="
                                            border-radius: 50%;
                                            position: relative;
                                            display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            width: 56px;
                                            height: 56px;
                                            min-width: 56px;
                                            min-height: 56px;
                                            background-color: rgb(
                                                255,
                                                224,
                                                218
                                            );
                                            border-radius: 50%;
                                            background-size: cover;
                                            background-position: 50% center;
                                            background-repeat: no-repeat;
                                            margin-right: 20px;
                                        "
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            style="width: 59%; height: 100%"
                                            fill="#5c5c5cff"
                                            viewBox="0 0 16 16"
                                        >
                                            <path
                                                d="M11.752 5.083c0 2.07-1.68 3.75-3.75 3.75-2.07 0-3.75-1.68-3.75-3.75 0-2.07 1.68-3.75 3.75-3.75 2.07 0 3.75 1.68 3.75 3.75Zm-1.25 0c0-1.377-1.123-2.5-2.5-2.5a2.504 2.504 0 0 0-2.5 2.5c0 1.378 1.123 2.5 2.5 2.5s2.5-1.122 2.5-2.5Z"
                                                clip-rule="evenodd"
                                            ></path>
                                            <path
                                                d="M7.998 10.515c-2.407 0-4.389 1.373-4.641 3.654-.03.274-.251.499-.527.499h-.163a.469.469 0 0 1-.479-.5c.256-2.936 2.759-4.816 5.81-4.816 3.053 0 5.557 1.88 5.813 4.816a.469.469 0 0 1-.479.5h-.163c-.276 0-.497-.225-.527-.5-.252-2.28-2.234-3.653-4.643-3.653Z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <div class="rate-creator-info">
                                            <h6 class="creator-name">{{ $review->user->name }}</h6>
                                            <div
                                                class="rate-content d-flex justify-content-between"
                                            >
                                                <div class="review me-3">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p>{{ $review->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        @if(auth()->check() && auth()->id() === $review->user_id)
                                            <button type="button" class="btn btn-outline-primary btn-sm" 
                                                    onclick="location.href='#review-form'">Edit</button>
                                        @endif 
                                    </div> 
                                </div>
                                <div class="comment-body card-body">
                                    <p class="m-0">{{ $review->comment }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <p class="comments d-flex flex-column justify-content-between col-sm-6 col-12">No reviews yet. Be the first to review!</p>
                        </div>  @endif
                    </div>
                </section>
            </div>
        </div>

@endsection
@section('user-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const audioReviewDiv = document.querySelector('.audio-review');
    if (audioReviewDiv) {
        const audioElement = audioReviewDiv.querySelector('#audio_review');
        
        audioReviewDiv.addEventListener('click', function() {
            // Make the audio element visible
            audioElement.style.display = 'block';
            audioElement.controls = true;
            audioElement.style.width = '100%';
            audioElement.style.marginTop = '10px';
            
            // Play the audio
            audioElement.play().catch(e => {
                console.error('Error playing audio:', e);
            });
        });
    }
        // PDF Download logic
        const pdfDownloadBtn = document.getElementById('pdf-download-btn');
        if (pdfDownloadBtn) {
            pdfDownloadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const timerDisplay = document.getElementById('download-timer');
                const countdownElement = document.getElementById('countdowndownload');
                let seconds = 10;
                
                timerDisplay.style.display = 'block';
                pdfDownloadBtn.disabled = true;
                
                const countdown = setInterval(function() {
                    seconds--;
                    countdownElement.textContent = seconds;
                    
                    if (seconds <= 0) {
                        clearInterval(countdown);
                        window.location.href = "{{ asset('storage/'.$book->pdf_link) }}?download=true";
                        timerDisplay.style.display = 'none';
                        pdfDownloadBtn.disabled = false;
                    }
                }, 1000);
            });
        }

        // Audio show logic
        const audioFullBtn = document.getElementById('audio-full-btn');
        if (audioFullBtn) {
            audioFullBtn.addEventListener('click', function(e) {
                @if(( $book->publisher->role == 'Publisher' && $book->publisher->hasActiveSubscription))
                        // Immediate show for subscribed publishers
                        document.querySelector('.all-audios').style.display = 'block';
                    @else
                        // Timer for others
                        e.preventDefault();
                        const timerAudioDisplay = document.getElementById('audios-timer');
                        const countdownElement = document.getElementById('countdownaudio');
                        let seconds = 10;
                        
                        timerAudioDisplay.style.display = 'block';
                        audioFullBtn.disabled = true;
                        
                        const countdown = setInterval(function() {
                            seconds--;
                            countdownElement.textContent = seconds;
                            
                            if (seconds <= 0) {
                                clearInterval(countdown);
                                document.querySelector('.all-audios').style.display = 'block';
                                timerAudioDisplay.style.display = 'none';
                                audioFullBtn.disabled = false;
                            }
                        }, 1000);
                    @endif
                
            });
        }

        // Star Rating Functionality
        document.querySelectorAll('.star-rating').forEach(ratingContainer => {
        const stars = ratingContainer.querySelectorAll('.star-icon');
        const hiddenInput = ratingContainer.querySelector('#rating-value');
        
        // Initialize stars based on current value
        const currentRating = parseInt(hiddenInput.value);
        if (currentRating > 0) {
            highlightStars(stars, currentRating);
        }
        
        // Add event listeners
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = parseInt(this.getAttribute('data-value'));
                hiddenInput.value = value;
                highlightStars(stars, value);
            });
            
            star.addEventListener('mouseover', function() {
                const value = parseInt(this.getAttribute('data-value'));
                highlightStars(stars, value, true);
            });
            
            star.addEventListener('mouseout', function() {
                const currentValue = parseInt(hiddenInput.value);
                highlightStars(stars, currentValue);
            });
        });
    });
    
    function highlightStars(stars, upToIndex, isHover = false) {
        stars.forEach((star, index) => {
            star.classList.remove('selected', 'hover');
            
            if (index < upToIndex) {
                star.classList.add(isHover ? 'hover' : 'selected');
            }
            
            // Update star icons (solid for selected, regular for others)
            if (star.classList.contains('selected') || star.classList.contains('hover')) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }

});    //delete comment
    function confirmDelete(reviewId) {
    if (confirm('Are you sure you want to delete this review?')) {
        document.getElementById('delete-form-' + reviewId).submit();
    }
}
</script>
@endsection