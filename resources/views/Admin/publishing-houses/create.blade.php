@extends('layouts.admin')

@section('admin-title',  'Create Publishing House')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ isset($publishingHouse) ? 'Edit' : 'Create' }} Publishing House</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($publishingHouse) ? route('admin.publishing-houses.update', $publishingHouse->id) : route('admin.publishing-houses.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($publishingHouse))
                @method('PUT')
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="name" name="name" 
                           value="{{ old('name', $publishingHouse->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if(isset($publishingHouse) && $publishingHouse->image)
                        @php
                            $storagePath = public_path('storage/' .$publishingHouse->image);
                            $publicPath = public_path( 'assets/images/' . $publishingHouse->image);
                            if (!empty($publishingHouse->image) && file_exists($storagePath)) {
                                $imageUrl = asset('storage/' . $publishingHouse->image);
                            } elseif (!empty($publishingHouse->image) && file_exists($publicPath)) {
                                $imageUrl = asset( 'assets/images/' .$publishingHouse->image);
                            }else {
                                $imageUrl =asset('assets/images/' .'publishing_houses/defualt.jpg' );
                            }      
                        @endphp
                        <div class="mt-2">
                            <img src="{{ $imageUrl }}" width="100" class="img-thumbnail">
                        </div>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="location" class="form-label">Location*</label>
                    <input type="text" class="form-control" id="location" name="location" 
                           value="{{ old('location', $publishingHouse->location ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="website" class="form-label">Website*</label>
                    <input type="url" class="form-control" id="website" name="website" 
                           value="{{ old('website', $publishingHouse->website ?? '') }}" required>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.publishing-houses.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Publishing House</button>
            </div>
        </form>
    </div>
</div>
@endsection