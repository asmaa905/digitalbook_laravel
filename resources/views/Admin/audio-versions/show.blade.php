@extends('layouts.admin')

@section('admin-title', 'Show New Audio - ')
@section('admin-content')
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Audio Book Details</h5>
        <div>
            <a href="{{ route('admin.audio-versions.edit', $audioVersion->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.audio-versions.create') }}" 
               class="btn  btn-primary btn-sm">
                <i class="fas fa-headphones"></i> Add New Audio Version
            </a>
        </div>
        </div>

    <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="book_id" class="form-label">Book</label>
                    <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id" disabled>
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
                    <label for="language" class="form-label">Language</label>
                    <select class="form-select @error('language') is-invalid @enderror" id="language" name="language" disabled>
                        <option value="en" {{ old('language', $audioVersion->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $audioVersion->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language', $audioVersion->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="de" {{ old('language', $audioVersion->language ?? '') == 'de' ? 'selected' : '' }}>German</option>
                    </select>
                  
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="audio_duration" class="form-label">Duration (in seconds)</label>
                    <input type="number" class="form-control @error('audio_duration') is-invalid @enderror" id="audio_duration" name="audio_duration" 
                           value="{{ old('audio_duration', $audioVersion->audio_duration ?? '') }}" disabled>
                   
                </div>
                <div class="col-md-6">
                    <label for="audio_file" class="form-label">Audio File (Max: 64MB)</label>
                    <input type="file" class="form-control @error('audio_file') is-invalid @enderror" id="audio_file" name="audio_file" accept="audio/*" disabled>
                  
                   
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
                <label for="review_record_link" class="form-label">Review Record Link</label>
                <input type="file" class="form-control @error('review_record_link') is-invalid @enderror" id="review_record_link" name="review_record_link" accept="audio/*" disabled>
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

            <div class="row mb-3">
                <div class="col-md-6">
                    <label  class="form-label">Narrior</label>
                    <p type="text" class="form-control"  >{{$audioVersion->creator->name}}</p>
                   
                </div>
                </div>
            <div class="mb-3">
                <label for="is_published" class="form-label">Publish Status</label>
                <select class="form-select @error('is_published') is-invalid @enderror" id="is_published" name="is_published" disabled>
                    <option value="">Select status</option>
                    <option value="waiting" {{ old('is_published', $audioVersion->is_published ?? '') == 'waiting' ? 'selected' : '' }}>waiting</option>
                    <option value="accepted" {{ old('is_published', $audioVersion->is_published ?? '') == 'accepted' ? 'selected' : '' }}>accepted</option>
                    <option value="rejected" {{ old('is_published', $audioVersion->is_published ?? '') == 'rejected' ? 'selected' : '' }}>rejected</option>
                </select>
           
            </div>


           
    </div>
</div>
@endsection