@extends('layouts.admin')

@section('admin-title', 'Manage Audio Versions')

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Audio Versions Management</h5>
        <a href="{{ route('admin.audio-versions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Audio Version
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Book Cover</th>
                        <th>Book Title</th>
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
                            @if($audio->book->image)
                                <img src="{{ asset('storage/'.$audio->book->image) }}" width="50" height="70" class="img-thumbnail">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:70px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $audio->book->title }}</td>
                        <td>{{ $audio->book->author->name ?? 'N/A' }}</td>
                        <td>
                            @if($audio->audio_link)
                                <audio controls style="width: 150px; height: 40px;">
                                    <source src="{{ asset('storage/'.$audio->audio_link) }}" type="audio/mpeg">
                                </audio>
                            @else
                                <span class="text-danger">No audio</span>
                            @endif
                        </td>
                        <td>{{ gmdate("H:i:s", $audio->audio_duration) }}</td>
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
            {{ $audioVersions->links() }}
        </div>
    </div>
</div>
@endsection