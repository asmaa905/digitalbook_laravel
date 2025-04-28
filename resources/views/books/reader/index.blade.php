@extends('layouts.user')
@section('user-title', 'Readed Books')
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
    
    .book-card {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        gap: 0.5rem;
        border: 0.8px solid #ccc;
        width: 166.4px;
        /* height: 250px; */

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
    <div class="main-sections" style="padding-top:109px !important">
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
                        <a
                            href="{{route('books.reader.index')}}"
                            style="
                                text-decoration-line: none !important;
                                text-decoration: none !important;
                            "
                            class="sc-e408b72-0 kAwrBF"
                            >Readed books</a
                        >
                    </li>
                </ul>
            </nav>
                
            @if($readBooks->isEmpty())
                <div class="alert alert-info">
                    You haven't read any books yet.
                </div>
            @else
            <section class="books-section featured-books">
                <div class="row px-0 mx-0">
                    <div
                        class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                    >
                        <h3 class="sec-title">Readed Books</h3>
                        
                    </div>
                </div>
                <div class="cards row p-0 m-0">
                @foreach($readBooks as $book)

                    <a href="{{ route('user.books.show', $book->id) }}" 
                        class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6 text-decoration-none"
                        style="border-radius: 5px">
                        @auth
                            @if(auth()->user()->role !== 'Admin' && auth()->user()->role !== 'Publisher' && isset($book) )
                                @php
                                    $isFav = auth()->user()->favBooks->contains($book->id);
                                @endphp

                                <form method="POST" action="{{ route('books.reader.makeFav', $book) }}" class="position-absolute" style="top:5px;right:5px">
                                    @csrf
                                    <button type="submit" class="btn  rounded-sm px-1  btn-fav" style="padding-top:1px;padding-bottom:1px ">
                                            <i class="{{ $isFav ? 'fas' : 'far' }} fa-heart mr-2 text-dark"></i>
                                        
                                    </button>
                                </form>
                            @endif
                        @endauth   
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
                            @if (strlen($book->title) > 20)
                                {{substr($book->title, 0, 20) . "..."}}
                            @else 
                            {{cutText($book->title)}} 
                            @endif
                            </h5>
                            <p class="card-text pb-0 mb-0">
                            {{ $book->author->name ?? 'Unknown Author' }}
                            </p>
                            <p class="card-text pb-0 mb-0 pt-2"><strong class="text-dark">Read at:</strong> {{ $book->pivot->read_date }}</p>
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

                    {{ $readBooks->links('pagination::bootstrap-5') }}

                </section>

            @endif
        </div>
    </div>
@endsection