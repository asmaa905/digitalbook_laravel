@extends('layouts.profile-layout')

@section('page-title', 'Add Audio Version -')
@section('page-styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/postbook.css')}}" />
<style>
    .file-upload {
        position: relative;
        overflow: hidden;
        padding: 2rem;
        border: 2px dashed #ccc;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }
    .file-upload:hover {
        border-color: #666;
        background-color: #f9f9f9;
    }
    .file-upload-input {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .file-upload-text, .file-upload-subtext {
        pointer-events: none;
    }
    .duration-input {
        font-family: monospace;
        letter-spacing: 1px;
    }
</style>
@endsection

@section('page-header-cont')
<h1>My Published books</h1>
<p class="account-name">Add Audio Version to Book</p>
@endsection

@section('page-content')
<div class="main-content">
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">{{ isset($audioVersion) ? $audioVersion->book->title:''}} Audio Version</h1>
                <div class="breadcrumb">
                    <a href="{{route('publisher.books.index')}}">Published Books</a>
                    <span class="separator">/</span>
                    <a href="{{route('publisher.books.index', ['#audio'])}}">Audio Versions</a>
                    <span class="separator">/</span>
                    <span>{{ isset($audioVersion) ? $audioVersion->book->title:''}}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="#" enctype="multipart/form-data">
    

            <div class="form-section">
                <div class="section-header">
                    <div>
                        <div class="section-title">Audio Version Details</div>
                        <div class="section-subtitle">
                            Provide details for the audio version
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Book*</label>
                    <select name="book_id" class="form-control"  {{ isset($audioVersion) ? 'disabled' : '' }}>
                        @if(isset($audioVersion->book))
                            <option value="{{ $audioVersion->book->id }}" selected>{{ $audioVersion->book->title }}</option>
                            <input type="hidden" name="book_id" value="{{ $audioVersion->book->id }}">
                                                @endif
                    </select> 
                      
                </div>
               
                <div class="form-group">
                    <label>Language*</label>
                    <select name="language" class="form-control" disabled>
                        <option value="en" @if(isset($audioVersion) && $audioVersion->language == 'en') selected @endif>English</option>
                        <option value="ar" @if(isset($audioVersion) && $audioVersion->language == 'ar') selected @endif>Arabic</option>
                        <option value="es" @if(isset($audioVersion) && $audioVersion->language == 'es') selected @endif>Spanish</option>
                        <option value="in" @if(isset($audioVersion) && $audioVersion->language == 'in') selected @endif>Indian</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Audio Duration (HH:MM:SS)*</label>
                        <input
                            type="text"
                            class="form-control duration-input"
                            name="audio_duration"
                            id="audioDuration"
                            value="{{ isset($audioVersion) ? gmdate('H:i:s', $audioVersion->audio_duration) : old('audio_duration', '00:00:00') }}"
                            placeholder="00:00:00"
                            pattern="\d{2}:[0-5][0-9]:[0-5][0-9]"
                            title="Please enter duration in HH:MM:SS format (e.g., 01:20:00)"
                            disabled
                        />
                        <small class="text-muted">Format: HH:MM:SS (e.g., 01:20:00 for 1 hour 20 minutes). Will be calculated automatically if left empty when uploading file.</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Full Audio File*</label>
            
                    @if(isset($audioVersion) && $audioVersion->audio_link)
                        <div class="mt-2">
                            <audio controls src="{{ Storage::url($audioVersion->audio_link) }}"></audio>
                            <small>Current file: {{ basename($audioVersion->audio_link) }}</small>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label>Review Audio File (Optional)</label>
                   
                    @if(isset($audioVersion) && $audioVersion->review_record_link)
                        <div class="mt-2">
                            <audio controls src="{{ Storage::url($audioVersion->review_record_link) }}"></audio>
                            <small>Current file: {{ basename($audioVersion->review_record_link) }}</small>
                        </div>
                    @else
                        <div class="mt-2">
                            no review audio uploaded
                        </div>
                    @endif
                </div>
            </div>

          
        </form>
    </div>
</div>
@endsection

@section('page-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the file upload areas
    const audioUploadArea = document.getElementById('audioUploadArea');
    const reviewUploadArea = document.getElementById('reviewUploadArea');
    const audioInput = document.getElementById('audio_full');
    const reviewInput = document.getElementById('audio_review');
    const durationInput = document.getElementById('audioDuration');
    
    // Make the entire area clickable
    audioUploadArea.addEventListener('click', function(e) {
        if (e.target !== audioInput) {
            audioInput.click();
        }
    });
    
    reviewUploadArea.addEventListener('click', function(e) {
        if (e.target !== reviewInput) {
            reviewInput.click();
        }
    });
    
    // Auto-format duration input
    durationInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Add colons automatically
        if (value.length > 2) {
            value = value.substring(0, 2) + ':' + value.substring(2);
        }
        if (value.length > 5) {
            value = value.substring(0, 5) + ':' + value.substring(5, 7);
        }
        
        // Limit to HH:MM:SS format
        if (value.length > 8) {
            value = value.substring(0, 8);
        }
        
        e.target.value = value;
    });

    // Calculate duration when audio file is selected
    audioInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Update UI to show file name
        const fileName = file.name;
        const textElement = audioUploadArea.querySelector('.file-upload-text');
        if (textElement) {
            textElement.textContent = `Selected: ${fileName}`;
        }
        
        // Calculate duration
        const audio = document.createElement('audio');
        audio.preload = 'metadata';
        
        audio.onloadedmetadata = function() {
            const duration = Math.round(audio.duration);
            const hours = Math.floor(duration / 3600).toString().padStart(2, '0');
            const minutes = Math.floor((duration % 3600) / 60).toString().padStart(2, '0');
            const seconds = Math.floor(duration % 60).toString().padStart(2, '0');
            
            durationInput.value = `${hours}:${minutes}:${seconds}`;
        };
        
        audio.src = URL.createObjectURL(file);
    });
    
    // Update UI for review file selection
    reviewInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const fileName = file.name;
        const textElement = reviewUploadArea.querySelector('.file-upload-text');
        if (textElement) {
            textElement.textContent = `Selected: ${fileName}`;
        }
    });
});
</script>
@endsection