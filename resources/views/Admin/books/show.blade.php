@extends('layouts.admin')

@section('admin-title', 'Book Details')

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Book Details</h5>
        <div>
            <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.audio-versions.create', ['book_id' => $book->id]) }}" 
               class="btn btn-primary btn-sm">
                <i class="fas fa-headphones"></i> Add Audio Version
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center">

                @if($book->image)
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
                    <img src="{{ $imageUrl }}" class="img-fluid rounded mb-3" alt="Book Cover">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:300px;">
                        <i class="fas fa-book fa-5x text-muted"></i>
                    </div>
                @endif
              
            </div>
            <div class="col-md-8">
                <h2>{{ $book->title }}</h2>
                <p class="text-muted">by {{ $book->author?->name ?? 'Unknown Author' }}</p>
                
                <div class="mb-4">
                    <span class="badge bg-primary">{{ $book->category?->name }}</span>
                    @if($book->is_featured)
                        <span class="badge bg-success ms-2">Featured</span>
                    @endif
                    <span class="badge bg-info ms-2">{{ strtoupper($book->language) }}</span>
                </div>
                
                <div class="row mb-4">
                    
                    <div class="col-md-4">
                        <h6>Published Date</h6>
                        <p>{{ $book->publish_date?->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Publishing House</h6>
                        <p>{{ $book->publishingHouse?->name ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <h5>Description</h5>
                <p>{{ $book->description }}</p>
                @if(isset($book) && $book->pdf_link)
                    @php
                        $storageDownloadbookPath = public_path('storage/' .$book->pdf_link);
                        $publicDownloadbookPath = public_path('assets/' . $book->pdf_link);
                        if (!empty($book->pdf_link) && file_exists($storageDownloadbookPath)) {
                            $book_download_path = asset('storage/' . $book->pdf_link);
                        } elseif (!empty($book->pdf_link) && file_exists($publicDownloadbookPath)) {
                            $book_download_path = asset('assets/' .$book->pdf_link);
                        } else {
                            $book_download_path = asset('assets/books_pdf/book_defualt2.pdf');
                        }      
                    @endphp                                    
                    <div class="mt-2" id="existing-file-container">
                        <div class="d-flex align-items-center">
                            
                            <div>
                            <a href="{{ $book_download_path }}" target="_blank" class="btn btn-outline-primary"
                                download="{{$book->title}}.pdf">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                                
                            </div>
                        </div>
                    </div>
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
                                    <a href="{{  asset('storage/'.$audio->audio_link) }}" target="_blank">Listen</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $audio->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.audio-versions.edit', $audio->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.audio-versions.destroy', $audio->id) }}" method="POST">
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