@extends('layouts.admin')

@section('admin-title', '- Create New Audio')
@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($audioVersion) ? 'Edit' : 'Create' }} Audio Version</h5>
    </div>
    <div class="card-body">
        <!-- Display validation errors at the top -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ isset($audioVersion) ? route('admin.audio-versions.update', $audioVersion->id) :  route('admin.audio-versions.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($audioVersion))
                @method('PUT')
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="book_id" class="form-label">Book*</label>
                    <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id" required {{ isset($book) ? 'disabled' : '' }}>
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
                    @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="language" class="form-label">Language*</label>
                    <select class="form-select @error('language') is-invalid @enderror" id="language" name="language" required>
                        <option value="en" {{ old('language', $audioVersion->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $audioVersion->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language', $audioVersion->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="de" {{ old('language', $audioVersion->language ?? '') == 'de' ? 'selected' : '' }}>German</option>
                    </select>
                    @error('language')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="audio_duration" class="form-label">Duration (in seconds)*</label>
                    <input type="number" class="form-control @error('audio_duration') is-invalid @enderror" id="audio_duration" name="audio_duration" 
                           value="{{ old('audio_duration', $audioVersion->audio_duration ?? '') }}" required>
                    @error('audio_duration')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="audio_file" class="form-label">Audio File* (Max: 64MB)</label>
                    <input type="file" class="form-control @error('audio_file') is-invalid @enderror" id="audio_file" name="audio_file" accept="audio/*" {{ !isset($audioVersion) ? 'required' : '' }}>
                    @error('audio_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if(isset($audioVersion) && $audioVersion->audio_link)
                        @php
                            $storagePath = public_path('storage/' .$audioVersion->audio_link);
                            $publicPath = public_path('assets/images/' . $audioVersion->audio_link);
                            if (!empty($audioVersion->audio_link) && file_exists($storagePath)) {
                                $audioUrl = asset('storage/' . $audioVersion->audio_link);
                            } elseif (!empty($audioVersion->audio_link) && file_exists($publicPath)) {
                                $audioUrl = asset('assets/images/' .$audioVersion->audio_link);
                            } else {
                                $audioUrl = false;
                            }      
                        @endphp
                        @if($audioUrl)
                        <div class="mt-2">
                            <audio controls>
                                <source src="{{ $audioUrl }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                        @else
                            <span class="text-danger">audio file not Available</span>
                        @endif
                    @endif
                    
                </div>
            </div>

            <div class="mb-3">
                <label for="review_record_file" class="form-label">Review Record Link</label>
                <input type="file" class="form-control @error('review_record_file') is-invalid @enderror" 
               id="review_record_file" name="review_record_file" accept="audio/*">
                @error('review_record_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if(isset($audioVersion) && $audioVersion->review_record_link)
                    @php
                        $storagePath = public_path('storage/' .$audioVersion->review_record_link);
                        $publicPath = public_path('assets/images/' . $audioVersion->review_record_link);
                        if (!empty($audioVersion->review_record_link) && file_exists($storagePath)) {
                            $audioReviewUrl = asset('storage/' .$audioVersion->review_record_link);
                        } elseif (!empty($audioVersion->review_record_link) && file_exists($publicPath)) {
                            $audioReviewUrl = asset('assets/images/' .$audioVersion->review_record_link);
                        } else {
                            $audioReviewUrl = false;
                        }      
                    @endphp
                    @if($audioReviewUrl)
                    <div class="mt-2">
                          <audio controls>
                                <source src="{{ $audioReviewUrl }}" type="audio/mp3">
                                Your browser does not support the audio element.
                          </audio>
                    </div>
                    @else
                        <span class="text-danger">audio file not Available</span>
                    @endif
                @endif

            </div>

            <div class="mb-3">
                <label for="is_published" class="form-label">Publish Status*</label>
                <select class="form-select @error('is_published') is-invalid @enderror" id="is_published" name="is_published" required>
                    <option value="">Select status</option>
                    <option value="waiting" {{ old('is_published', $audioVersion->is_published ?? '') == 'waiting' ? 'selected' : '' }}>waiting</option>
                    <option value="accepted" {{ old('is_published', $audioVersion->is_published ?? '') == 'accepted' ? 'selected' : '' }}>accepted</option>
                    <option value="rejected" {{ old('is_published', $audioVersion->is_published ?? '') == 'rejected' ? 'selected' : '' }}>rejected</option>
                </select>
                @error('is_published')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>


            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.audio-versions.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-orange">Save Audio Version</button>
            </div>
        </form>
    </div>
</div>
@endsection