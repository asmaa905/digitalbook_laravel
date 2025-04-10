@extends('layouts.publisher')

@section('title', 'Book Details')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Book Details</h5>
        <div>
            <a href="{{ route('publisher.books.edit', $book->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('publisher.audio-versions.create', ['book_id' => $book->id]) }}" 
               class="btn btn-primary btn-sm">
                <i class="fas fa-headphones"></i> Add Audio Version
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">
                @if($book->image)
                    <img src="{{ asset('storage/'.$book->image) }}" class="img-fluid rounded mb-3" alt="Book Cover">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:300px;">
                        <i class="fas fa-book fa-5x text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <h2>{{ $book->title }}</h2>
                <p class="text-muted">by {{ $book->author->name ?? 'Unknown Author' }}</p>
                
                <div class="mb-4">
                    <span class="badge bg-primary">{{ $book->category->name }}</span>
                    @if($book->is_featured)
                        <span class="badge bg-success ms-2">Featured</span>
                    @endif
                    <span class="badge bg-info ms-2">{{ strtoupper($book->language) }}</span>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <h6>Price</h6>
                        <p>${{ number_format($book->price, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Published Date</h6>
                        <p>{{ $book->publish_date->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Publishing House</h6>
                        <p>{{ $book->publishingHouse->name ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <h5>Description</h5>
                <p>{{ $book->description }}</p>
                
                @if($book->pdf_link)
                    <a href="{{ $book->pdf_link }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-file-pdf"></i> View PDF
                    </a>
                @endif
            </div>
        </div>
        
        <hr class="my-4">
        
        <h4 class="mb-3">Audio Versions</h4>
        @if($book->audioVersions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Language</th>
                            <th>Duration</th>
                            <th>Audio Link</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($book->audioVersions as $audio)
                        <tr>
                            <td>{{ strtoupper($audio->language) }}</td>
                            <td>{{ gmdate("H:i:s", $audio->audio_duration) }}</td>
                            <td>
                                @if($audio->audio_link)
                                    <a href="{{ $audio->audio_link }}" target="_blank">Listen</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $audio->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('publisher.audio-versions.edit', $audio->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('publisher.audio-versions.destroy', $audio->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">No audio versions available for this book.</div>
        @endif
    </div>
</div>
@endsection