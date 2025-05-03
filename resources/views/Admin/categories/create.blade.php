@extends('layouts.admin')

@section('admin-title', 'Create New Catgeory')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($category) ? 'Edit' : 'Create' }} Category</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $category->name ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-orange">Save Category</button>
            </div>
        </form>
    </div>
</div>
@endsection