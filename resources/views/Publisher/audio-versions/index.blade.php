@extends('layouts.publisher')

@section('title', 'Manage Audio Versions')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Audio Versions Management</h5>
        <a href="{{ route('publisher.audio-versions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Audio Version
        </a>
    </div>
    <div class="card-body">
        @if($books->count() > 0)
            @foreach($books as $book)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>{{ $book->title }}</h5>
                        <small class="text-muted">by {{ $book->author->name ?? 'Unknown Author' }} | {{ $book->category->name }}</small>
                    </div>
                    <div class="card-body">
                        @if($book->audioVersions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Language</th>
                                            <th>Format</th>
                                            <th>Duration</th>
                                            <th>Review Format</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($book->audioVersions as $audio)
                                        <tr>
                                            <td>{{ strtoupper($audio->language) }}</td>
                                            <td>{{ $audio->audio_format_full_audio }}</td>
                                            <td>{{ gmdate("H:i:s", $audio->audio_duration) }}</td>
                                            <td>{{ $audio->audio_format_review }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
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
            @endforeach
            <div class="mt-3">
                {{ $books->links() }}
            </div>
        @else
            <div class="alert alert-info">No books found. Please add books first.</div>
        @endif
    </div>
</div>
@endsection