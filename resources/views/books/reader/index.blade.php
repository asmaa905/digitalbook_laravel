@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Read Books</h1>
    
    @if($readBooks->isEmpty())
        <div class="alert alert-info">
            You haven't read any books yet.
        </div>
    @else
        <div class="row">
            @foreach($readBooks as $book)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($book->cover_image) }}" class="card-img-top" alt="{{ $book->title }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $book->title }}</h5>
                            <p class="card-text">{{ Str::limit($book->description, 100) }}</p>
                            <p>Read on: {{ $book->pivot->read_at->format('M d, Y') }}</p>
                            -{{--@if($book->pivot->rating)
                                <p>Your rating: {{ $book->pivot->rating }}/5</p>
                            @endif--}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        {{ $readBooks->links() }}
    @endif
</div>
@endsection