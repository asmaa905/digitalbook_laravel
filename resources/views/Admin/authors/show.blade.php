@extends('layouts.admin')

@section('admin-title', 'Show Author')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">show Author</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($author) ? route('admin.authors.update', $author->id) : route('admin.authors.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($author))
                @method('PUT')
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name', $author->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Photo</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if(isset($author) && $author->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$author->image) }}" width="100" class="img-thumbnail">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="bio" class="form-label">Biography</label>
                <textarea class="form-control" id="bio" name="bio" rows="5">{{ old('bio', $author->bio ?? '') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.authors.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-orange">Save Author</button>
            </div>
        </form>
    </div>
</div>
@endsection