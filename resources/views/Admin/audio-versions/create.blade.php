@extends('layouts.admin')

@section('admin-title', '- Create New Audio')
@section('admin-nav-title', 'Create New Audio')
@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($audioVersion) ? 'Edit' : 'Create' }} Audio Version</h5>
    </div>
    <div class="card-body">
    <form method="POST" action="{{ isset($audioVersion) ? route('admin.audio-versions.update', $audioVersion->id) :  route('admin.audio-versions.store') }}" enctype="multipart/form-data">
    @csrf
            @if(isset($audioVersion))
                @method('PUT')
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="book_id" class="form-label">Book*</label>
                    <select class="form-select" id="book_id" name="book_id" required {{ isset($book) ? 'disabled' : '' }}>
                        @if(isset($book))
                            <option value="{{ $book->id }}" selected>{{ $book->title }}</option>
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                        @else
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" 
                                    {{ old('book_id', $audioVersion->book_id ?? '') == $book->id ? 'selected' : '' }}>
                                    {{ $book->title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="language" class="form-label">Language*</label>
                    <select class="form-select" id="language" name="language" required>
                        <option value="en" {{ old('language', $audioVersion->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $audioVersion->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language', $audioVersion->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="de" {{ old('language', $audioVersion->language ?? '') == 'de' ? 'selected' : '' }}>German</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="audio_duration" class="form-label">Duration (in seconds)*</label>
                    <input type="number" class="form-control" id="audio_duration" name="audio_duration" 
                           value="{{ old('audio_duration', $audioVersion->audio_duration ?? '') }}" required>
                </div>
                <div class="col-md-6">
                <label for="audio_file" class="form-label">Audio File* (Max: 64MB)</label>
                                    <input type="file" class="form-control" id="audio_file" name="audio_file" accept="audio/*" {{ !isset($audioVersion) ? 'required' : '' }}>
                    @if(isset($audioVersion) && $audioVersion->audio_link)
                        <div class="mt-2">
                            <audio controls>
                                <source src="{{ $audioVersion->audio_link }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="review_record_file" class="form-label">Review Record Link</label>
                <input type="file" class="form-control" id="review_record_file" name="review_record_file" accept="audio/*">
                    @if(isset($audioVersion) && $audioVersion->review_record_link)
                        <div class="mt-2">
                            <audio controls>
                                <source src="{{ $audioVersion->review_record_link }}" type="audio/mp3">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endif
               {{-- <input type="text" class="form-control" id="review_record_file" name="review_record_file" 
                       value="{{ old('review_record_link', $audioVersion->review_record_link ?? '') }}"> --}}
            </div>
            <div class="row mb-3">
            <div class="col-md-6">
                <label for="audio_format_full_audio" class="form-label">Audio Format*</label>
                <select class="form-select" id="audio_format_full_audio" name="audio_format_full_audio" required>
                    <option value="MP3">MP3</option>
                    <option value="AAC">AAC</option>
                    <option value="WAV">WAV</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="audio_format_review" class="form-label">Review Format*</label>
                <select class="form-select" id="audio_format_review" name="audio_format_review" required>
                    <option value="MP3">MP3</option>
                    <option value="AAC">AAC</option>
                    <option value="WAV">WAV</option>
                </select>
            </div>
        </div>
            <div class="d-flex justify-content-between">
                <a href="{{ isset($book) ?? route('admin.books.show', $book->id)}}"
                   class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Audio Version</button>
            </div>
        </form>
    </div>
</div>
@endsection