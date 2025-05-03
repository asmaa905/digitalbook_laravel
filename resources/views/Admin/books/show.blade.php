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
               class="btn  btn-primary btn-sm">
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
                            <td>{{ $audio->language=='en'?'english':($audio->language =='ar'?'arabic':$audio->language) }}</td>
                            <!-- In your table row (replace the current duration td) -->
                            @if($audio->audio_link)
                            @php
                                $storagePath = public_path('storage/' .$audio->audio_link);
                                $publicPath = public_path('assets/images/' . $audio->audio_link);
                                
                                if (!empty($audio->audio_link)) {
                                    if (file_exists($storagePath)) {
                                        $audioPath = $storagePath;
                                        $audioUrl = asset('storage/' . $audio->audio_link);
                                    } elseif (file_exists($publicPath)) {
                                        $audioPath = $publicPath;
                                        $audioUrl = asset('assets/images/' .$audio->audio_link);
                                    } else {
                                        $audioUrl = false;
                                    }
                                    
                                    // Calculate duration if file exists
                                    if ($audioUrl && file_exists($audioPath)) {
                                        $getID3 = new getID3();
                                        $fileInfo = $getID3->analyze($audioPath);
                                        $duration = $fileInfo['playtime_seconds'] ?? 0;
                                    } else {
                                        $duration = 0;
                                    }
                                } else {
                                    $audioUrl = false;
                                    $duration = 0;
                                }
                            @endphp
                                
                            <td class="audio-duration" data-audio-url="{{ $audioUrl ?? '' }}">
                                @if($audioUrl)
                                    {{ gmdate("H:i:s", $duration) }}
                                @else
                                    <span class="text-danger">audio not Available</span>
                                @endif
                            </td>
                            <td>
                           
                                @if($audioUrl)
                                <a href="#" onclick="playAudio('{{$audioUrl}}'); return false;">Listen</a>
                                @else
                                   <span class="text-danger">audio not Available</span>
                                @endif
                          {{--  @else--}}
                                <!-- <span class="text-danger">No audio</span> -->
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
@section('admin-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calculate durations for all audio files
            const durationCells = document.querySelectorAll('.audio-duration');
            
            durationCells.forEach(cell => {
                const audioUrl = cell.getAttribute('data-audio-url');
                if (!audioUrl) {
                    cell.textContent = 'N/A';
                    return;
                }
                
                const audio = new Audio(audioUrl);
                
                audio.addEventListener('loadedmetadata', function() {
                    const duration = audio.duration;
                    cell.textContent = formatTime(duration);
                });
                
                audio.addEventListener('error', function() {
                    cell.textContent = 'Error';
                });
            });
            
          
        });  function playAudio(url) {
                const audio = new Audio(url);
                
                audio.onloadedmetadata = function() {
                    const duration = audio.duration;
                    const modal = document.createElement('div');
                    modal.innerHTML = `
                        <div style="position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); 
                                    background:#fff; padding:20px; z-index:1000; border:1px solid #ccc; border-radius:5px">
                            <div>Duration: ${formatTime(duration)}</div>
                            <audio controls autoplay>
                                <source src="${url}" type="audio/mpeg">
                            </audio>
                            <button onclick="this.parentNode.parentNode.remove()" class="btn text-danger position-absolute top-0" style="right:6px;">X</button>
                        </div>
                    `;
                    document.body.appendChild(modal);
                };
                
                audio.onerror = function() {
                    alert('Error loading audio');
                };
            }
            
            function formatTime(seconds) {
                if (isNaN(seconds)) return '00:00:00';
                
                const hours = Math.floor(seconds / 3600);
                const minutes = Math.floor((seconds % 3600) / 60);
                const secs = Math.floor(seconds % 60);
                
                return [
                    hours.toString().padStart(2, '0'),
                    minutes.toString().padStart(2, '0'),
                    secs.toString().padStart(2, '0')
                ].join(':');
            }
    </script>
@endsection