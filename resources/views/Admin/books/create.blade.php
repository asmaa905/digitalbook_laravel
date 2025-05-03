@extends('layouts.admin')

@section('Admin-title')
{{ isset($book) ? 'Edit' : 'Create' }} Book -

@endsection

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($book) ? 'Edit' : 'Create' }} Book</h5>
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
        <form method="POST" action="{{ isset($book) ? route('admin.books.update', $book->id) : route('admin.books.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($book))
                @method('PUT')
            @endif
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Title*</label>
                    <input type="text" class="form-control" id="title" name="title" 
                           value="{{ old('title', $book->title ?? '') }}" required>
                </div>
                <div class="col-md-6">
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
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Category*</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ old('category_id', $book->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="publish_house_id" class="form-label">Publishing House*</label>
                    <select class="form-select" id="publish_house_id" name="publish_house_id" required>
                        <option value="">Select Publishing House</option>
                        @foreach($publishingHouses as $house)
                            <option value="{{ $house->id }}" 
                                {{ old('publish_house_id', $book->publish_house_id ?? '') == $house->id ? 'selected' : '' }}>
                                {{ $house->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="publish_date" class="form-label">Publish Date</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date" 
                    value="{{ old('publish_date', isset($book) ? $book->publish_date->format('Y-m-d') : '') }}" >
                    </div>
                <div class="col-md-4">
                    <label for="language" class="form-label">Language*</label>
                    <select class="form-select" id="language" name="language" required>
                        <option value="ar" {{ old('language', $book->language ?? '') == 'ar' ? 'selected' : '' }}>Arabic</option>
                        <option value="en" {{ old('language', $book->language ?? '') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language', $book->language ?? '') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language', $book->language ?? '') == 'fr' ? 'selected' : '' }}>French</option>
                        <option value="de" {{ old('language', $book->language ?? '') == 'de' ? 'selected' : '' }}>German</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description*</label>
                <textarea class="form-control" id="description" name="description" rows="5" required>{{ old('description', $book->description ?? '') }}</textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="image" class="form-label">Cover Image</label>
                    <input type="file" class="file-upload-input" name="image" accept="image/*" 
                        />    
                        @if(isset($book) && $book->image)
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
                               <div class="mt-2">
                                  <img src="{{ $imageUrl }}" width="100" class="img-thumbnail">
                               </div>
                         @endif
                </div>

                <div class="col-md-6">
                    <label for="pdf_link" class="form-label">Book File (PDF only)*</label>
                     <input type="file" class="form-control" id="pdf_link"  name="pdf_link" accept=".pdf"
                       />   
                    @if(isset($book) && $book->pdf_link)
                        <div class="mt-2" id="existing-file-container">
                            <div class="d-flex align-items-center">
                                @if(pathinfo($book->pdf_link, PATHINFO_EXTENSION) === 'pdf')
                                    <i class="fas fa-file-pdf fa-2x text-danger me-2"></i>
                                @else
                                    <i class="fas fa-file-word fa-2x text-primary me-2"></i>
                                @endif
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
                                <div>
                                    <a href="{{ $book_download_path }}"  target="_blank" rel="noopener"  class="d-block">
                                        View current file
                                    </a>
                                    <small class="text-muted">{{ $book->title }}.pdf</small>
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

            <div class="mb-3 form-check">


            <input type="hidden" name="is_featured" value="0">
<input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1"
    {{ old('is_featured', $book->is_featured ?? false) ? 'checked' : '' }}>


             
                <label class="form-check-label" for="is_featured">Featured Book</label>
            </div>
            <div class="mb-3">
                <label for="is_published" class="form-label">Accept Publish</label>
                <select class="form-select" id="is_published" name="is_published">
                    <option value="">Select reject/ accept</option>
                    
                        <option value="waiting" 
                            {{ old('is_published', $book->is_published ?? '') == 'waiting' ? 'selected' : '' }}>
                            waiting
                        </option>
                        <option value="accepted" 
                            {{ old('is_published', $book->is_published ?? '') == 'accepted' ? 'selected' : '' }}>
                            accepted
                        </option>
                        <option value="rejected" 
                            {{ old('is_published', $book->is_published ?? '') == 'rejected' ? 'selected' : '' }}>
                            rejected
                        </option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-orange">Save Book</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('pdf_link');
        const filePreview = document.getElementById('file-preview');
        const fileIcon = document.getElementById('file-icon');
        const fileName = document.getElementById('file-name');
        const fileSize = document.getElementById('file-size');
        const existingFileContainer = document.getElementById('existing-file-container');

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileType = file.name.split('.').pop().toLowerCase();
                
                // Validate file type
                if (fileType !== 'pdf') {
                    alert('Only PDF files are allowed.');
                    this.value = '';
                    return;
                }
                
                // Show preview
                filePreview.classList.remove('d-none');
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                
                // Set appropriate icon
                if (fileType === 'pdf') {
                    fileIcon.className = 'fas fa-file-pdf fa-2x text-danger me-2';
                } else {
                    fileIcon.className = 'fas fa-file-word fa-2x text-primary me-2';
                }
                
                // Hide existing file if present
                if (existingFileContainer) {
                    existingFileContainer.classList.add('d-none');
                }
            } else {
                filePreview.classList.add('d-none');
                if (existingFileContainer) {
                    existingFileContainer.classList.remove('d-none');
                }
            }
        });

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submitted'); // Check browser console
        });
    });
</script>
@endpush

@endsection