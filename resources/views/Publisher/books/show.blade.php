@extends('layouts.profile-layout')

@section('page-title', 'Book Details')

@section('page-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Book Details</h5>
        <div>
            <a href="{{ route('publisher.books.edit', $book->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('publisher.audio-versions.create', ['book_id' => $book->id]) }}" 
               class="btn bg-orange btn-sm">
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
                {{--<p class="text-muted"><strong>By</strong> {{ $book->author->name ?? 'Unknown author' }}</p>--}}

                
                <div class="mb-4">
                    <span class="badge bg-primary">{{ $book->category->name }}</span>
                    @if($book->is_featured)
                        <span class="badge bg-success ms-2">Featured</span>
                    @endif
                    <span class="badge bg-info ms-2">{{ strtoupper($book->language) }}</span>
                </div>
                
                <div class="row mb-4">
                <div class="col-md-4">
                        <h6>Published By</h6>
                        <p> {{ $book->publisher->name ?? 'Unknown publisher' }}</p>
                    </div>
                    <div class="col-md-4">
                        <h6>Published Date</h6>
                        <p>{{ $book->publish_date->format('M d, Y') }}</p>
                    </div>
                  
                </div>
                
                <h5>Description</h5>
                <p>{{ $book->description }}</p>
                
                
              
                @if(isset($book) && $book->pdf_link)
                        <div class="mt-2" id="existing-file-container">
                            <div class="d-flex align-items-center">
                              
                                <div>
                                <a href="{{ asset('storage/'.$book->pdf_link) }}"  class="btn btn-orange-outline">
                                    <i class="fas fa-file-pdf"></i> View PDF
                                </a>

                       

                                <a href="{{ asset('storage/'.$book->pdf_link) }}" target="_blank" class="btn bg-orange rounded-sm" download="{{$book->title}}.pdf" >
                                    <i class="fas fa-file-pdf"></i> Download
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
                            <th>Narrior</th>

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
                            <td>{{ $audio->creator->name }}</td>

                            <td>{{ $audio->created_at->format('M d, Y') }}</td>
                           
                            <td>
                                <div class="d-flex gap-2"> 
                               
                                    @auth
                                        @if(auth()->user()->id == $audio->creator->id)
                                        <a href="{{ route('publisher.audio-versions.show', $audio->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
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
                                        @endif
                                    @endauth
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