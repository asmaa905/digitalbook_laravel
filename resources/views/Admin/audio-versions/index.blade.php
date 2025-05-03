@extends('layouts.admin')

@section('admin-title', 'Manage Audio Versions')

@section('admin-content')
<div class="container-fluid">
    <div class="filter-container d-flex justify-content-between align-items-center">
      
        <strong class="mb-0">Audio Versions Management</strong>
        <a href="{{ route('admin.audio-versions.create') }}" class="btn btn-orange">
            <i class="fas fa-plus"></i> Add Audio Version
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Audio File</th>
                            <th>Duration</th>
                            <th>Language</th>
                            <th>Creator</th>

                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($audioVersions as $audio)
                        <tr>
                            <td>
                                @if($audio->book?->image)
                                @php
                                        $storagePath = public_path('storage/' . $audio->book->image);
                                        $publicPath = public_path( 'assets/images/' .  $audio->book->image);
                                        if (!empty( $audio->book->image) && file_exists($storagePath)) {
                                            $imageUrl = asset('storage/' .  $audio->book->image);
                                        } elseif (!empty( $audio->book->image) && file_exists($publicPath)) {
                                            $imageUrl = asset( 'assets/images/' . $audio->book->image);
                                        }else {
                                            $imageUrl =asset('assets/images/' .'books/book-1.jpg' );
                                        }      
                                    @endphp
                                    <img src="{{ $imageUrl }}" width="50" height="70" class="img-thumbnail">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:70px;">
                                        <i class="fas fa-book text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $audio->book?->title }}</td>
                            <td>{{ $audio->book?->author->name ?? 'N/A' }}</td>
                            @if($audio->audio_link)
                            <!-- <td> -->
                            
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
                                
                                <td>
                            
                                    @if($audioUrl)
                                    <audio controls style="width: 150px; height: 40px;">
                                            <source src="{{ $audioUrl }}" type="audio/mpeg">
                                        </audio>
                                    @else
                                    <span class="text-danger">audio not Available</span>
                                    @endif
                            
                                </td>
                                
                                <td class="audio-duration" data-audio-url="{{ $audioUrl ?? '' }}">
                                    @if($audioUrl)
                                        {{ gmdate("H:i:s", $duration) }}
                                    @else
                                        <span class="">00:00:00</span>
                                    @endif
                                </td>
                                @else
                                <span class="text-danger">No audio</span>
                                @endif
                            <td>{{ strtoupper($audio->language) }}</td>
                            <td>{{ $audio->creator->name ?? 'System' }}</td>
                            <td>
                                @if($audio->is_published == 'accepted')
                                    <span class="badge bg-success">Published</span>
                                @elseif($audio->is_published == 'waiting')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                    
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.audio-versions.show', $audio->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
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
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">No audio versions found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
               {{ $audioVersions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection