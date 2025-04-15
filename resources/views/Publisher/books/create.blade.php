@extends('layouts.profile-layout')

@section('page-title')
{{ isset($book) ? 'Edit' : 'Create' }} Book -

@endsection
@section('page-styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/postbook.css')}}" />
@endsection

@section('page-header-cont')
<h5 class="mb-0">{{ isset($book) ? 'Edit' : 'Create' }} Book</h5>
<p class="account-name">Post any book that has no copyright</p>
@endsection

@section('page-content')
<div class="main-content">
    <div class="container">
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">{{ isset($book) ? 'Edit' : 'Create' }} E-Book</h1>
                <div class="breadcrumb">
                    <a href="{{ route('publisher.books.index') }}">Publisher Dashboard</a>
                    <span class="separator">/</span>
                    <a href="{{ route('publisher.books.index') }}">E-Books</a>
                    <span class="separator">/</span>
                    <span>Upload</span>
                </div>
            </div>
           
        </div>
        @if($canCreateBook)

        <form method="POST" action="{{ isset($book) ? route('publisher.books.update', $book->id) : route('publisher.books.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif
            <div class="form-section">
                <div class="section-header">
                    <div>
                        <div class="section-title">Basic Information</div>
                        <div class="section-subtitle">
                            Provide basic details about your book
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Book Title*</label>
                        <input type="text" class="form-control"
                         value="{{ old('title', $book->title ?? '') }}"  name="title" required />
                    </div>
                    <div class="form-group">
                        <label for="author_id" class="form-label">Author*</label>
                        <select class="form-select" id="author_id" name="author_id" required>
                            <option value="">Select Author</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" 
                                    {{ old('author_id', $book->author_id ?? '') == $author->id ? 'selected' : '' }}>
                                    {{ $author->name }}
                                </option>
                            @endforeach
                        </select>
                        <p><a href="{{route('publisher.authors.create')}}"> add a new Author</a></p>
                    </div>
                </div>

                    <div class="form-row">
                        <div class="form-group">
                        <label>Category*</label>
                        <select class="form-control select" name="category_id" required>
                            <option value="">Select category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"{{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <p><a href="{{route('publisher.categories.create')}}"> add a new Category</a></p>

                    </div>
                </div>
               
                <div  class="form-group">
                    <label for="language" class="form-label">Language*</label>
                    <select class="form-select" id="language" name="language" required>
                        <option value="ar" {{ old('language', $book->language ?? '') == 'ar' ? 'selected' : '' }}>Arabic</option>
                        <option value="en" {{ old('language', $book->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $book->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language', $book->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="de" {{ old('language', $book->language ?? '') == 'de' ? 'selected' : '' }}>German</option>
                    </select>
                </div>
                <div  class="form-group">
                    <label for="publish_house_id" class="form-label">Publishing House</label>
                    <select class="form-select" id="publish_house_id" name="publish_house_id" required>
                        <option value="">Select Publishing House</option>
                        @foreach($publishingHouses as $house)
                            <option value="{{ $house->id }}" 
                                {{ old('publish_house_id', $book->publish_house_id ?? '') == $house->id ? 'selected' : '' }}>
                                {{ $house->name }}
                            </option>
                        @endforeach
                    </select>
                    <p><a href="{{route('publisher.publishing-houses.create')}}"> add a new Publishing House</a></p>

                </div>
                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured"  hidden />
                 
                <div class="form-group">
                    <label>Description*</label>
                    <textarea class="form-control" name="description" rows="5" required>  {{ old('description', $book->description ?? '') }}</textarea>
                </div> 
                 
            </div>

           <div class="form-section">
                <div class="section-header">
                    <div>
                        <div class="section-title">Book Cover</div>
                        <div class="section-subtitle">
                            Upload a cover image for your book
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Cover Image*</label>
                    <div class="file-upload" id="coverUploadArea" style="position:relative">
                    @php
                        $isnotimgRequired = ($type == 'edit' && asset($book) && $book->image);
                    @endphp

                    <input type="file" class="file-upload-input" name="image" accept="image/*" 
                    @if(!$isnotimgRequired) required @endif />
                        @if(isset($book) && $book->image)
                        <div class="img " id="coverPreview" style="height: 200px; width: 100%;">
                            <img id="coverPreviewImage" class="w-100 h-100" src="{{ asset('storage/'. old('image', $book->image ?? '')) }}" alt="image">
                        </div>
                        @endif
                       <div style="margin" class="mx-auto">
                        <div style="background-color:rgba(0,0,0,0.01)">
                             <i class="fas fa-image z-50  text-orange"></i>
                        <div class="file-upload-text">
                            Drag & drop your cover image here
                        </div>
                        <div class="file-upload-subtext">
                            or click to browse files (JPG, PNG)
                        </div>
                        </div>
                        
                       </div>
                     
                  
                    </div>
                    
                </div>
            </div>

            <div class="form-section">
                <div class="section-header">
                    <div>
                        <div class="section-title">Book Content</div>
                        <div class="section-subtitle">
                            Upload your book content
                        </div>
                    </div>
                </div>

                  <!-- Fix the PDF file input -->

          <div class="form-group">
        <label for="pdf_link" class="form-label">Book File (PDF or DOCX only)*</label>
        @php
            $isnotpdfRequired = ($type == 'edit' && asset($book) && $book->pdf_link);
        @endphp

         <input type="file" class="form-control" id="pdf_link" name="pdf_link" accept=".pdf,.docx"
            @if(!$isnotpdfRequired) required @endif />
                    @if(isset($book) && $book->pdf_link)
                        <div class="mt-2" id="existing-file-container">
                            <div class="d-flex align-items-center">
                                @if(pathinfo($book->pdf_link, PATHINFO_EXTENSION) === 'pdf')
                                    <i class="fas fa-file-pdf fa-2x text-danger me-2"></i>
                                @else
                                    <i class="fas fa-file-word fa-2x text-primary me-2"></i>
                                @endif
                                <div>
                                    <a href="{{ asset('storage/'.$book->pdf_link) }}" target="_self" class="d-block">
                                        View current file
                                    </a>
                                    <small class="text-muted">{{ basename($book->pdf_link) }}</small>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div id="file-preview" class="mt-2 d-none">
                        <div class="d-flex align-items-center">
                            <i id="file-icon" class="fas fa-2x me-2"></i>
                            <div>
                                <span id="file-name" class="d-block"></span>
                                <small class="text-muted" id="file-size"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-header">
                    <div>
                        <div class="section-title">Publishing Options</div>
                        <div class="section-subtitle">
                            Choose when and how to publish your book
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="publish_date" class="form-label">Publish Date</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date" 
                    value="{{ old('publish_date', isset($book) ? $book->publish_date->format('Y-m-d') : '') }}" >
                    </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('publisher.books.index') }}" class="btn btn-orange-outline">Cancel</a>
                <button type="submit" class="btn bg-orange" id="publishBtn">
                    Publish Book
                </button>

                
            </div>
        </form>
        @else
            <div class="alert alert-danger">
              You have reached your book limit. <a href="{{ route('publisher.subscriptions.plans') }}">Subscribe</a> to publish more books.
          </div>
        @endif
    </div>
</div>
@endsection

@section('page-scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Cover image preview
        const coverUploadArea = document.getElementById("coverUploadArea");
        const coverInput = document.querySelector("input[name='image']");
        const coverPreview = document.getElementById("coverPreviewImage");

        coverUploadArea.addEventListener("click", function () {
            coverInput.click();
        });

        coverInput.addEventListener("change", function () {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                    // coverPreview.style.display = "block";
                };
                reader.readAsDataURL(this.files[0]);
            }
        });

    

        // Form validation
        document.getElementById("publishBtn").addEventListener("click", function(e) {
            const form = this.closest("form");
            let isValid = true;
        
            // Check required fields
            const requiredFields = form.querySelectorAll("[required]");
            requiredFields.forEach(field => {
                if (!field.value || (field.type === 'file' && field.files.length === 0)) {
                    field.style.borderColor = "red";
                    isValid = false;
                } else {
                    field.style.borderColor = "";
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert("Please fill in all required fields");
            } else {
                // Ensure form submits normally if valid
                form.submit();
            }
        });
    });
</script>
@endsection