@extends('layouts.publisher')

@section('title', 'Manage Books')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($book) ? 'Edit' : 'Create' }} Book</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($book) ? route('publisher.books.update', $book->id) : route('publisher.books.store') }}" enctype="multipart/form-data">
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
                    <label for="publish_house_id" class="form-label">Publishing House</label>
                    <select class="form-select" id="publish_house_id" name="publish_house_id">
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
                    <label for="price" class="form-label">Price*</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" 
                           value="{{ old('price', $book->price ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="publish_date" class="form-label">Publish Date*</label>
                    <input type="date" class="form-control" id="publish_date" name="publish_date" 
                    value="{{ old('publish_date', isset($book) ? $book->publish_date->format('Y-m-d') : '') }}" required>
                    </div>
                <div class="col-md-4">
                    <label for="language" class="form-label">Language*</label>
                    <select class="form-select" id="language" name="language" required>
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
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if(isset($book) && $book->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$book->image) }}" width="100" class="img-thumbnail">
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label for="pdf_link" class="form-label">PDF Link</label>
                    <input type="text" class="form-control" id="pdf_link" name="pdf_link" 
                           value="{{ old('pdf_link', $book->pdf_link ?? '') }}">
                </div>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                       {{ old('is_featured', $book->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">Featured Book</label>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('publisher.books.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Book</button>
            </div>
        </form>
    </div>
</div>
@endsection