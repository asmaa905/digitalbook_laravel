@extends('layouts.admin')

@section('admin-title',  'Manage Publishing Houses')

@section('admin-content')
<div class="container-fluid">
    <div class="filter-container d-flex justify-content-between align-items-center">
      
    <strong class="mb-0">Publishing Houses Management</strong>
    <a href="{{ route('admin.publishing-houses.create') }}" class="btn btn-orange">
            <i class="fas fa-plus"></i> Add Publishing House
        </a>
    </div>
<div class="card">
  
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Website</th>
                        <th>Books Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publishingHouses as $house)
                    <tr>
                        <td>
                            @if($house->image)
                            @php
                                    $storagePath = public_path('storage/' .$house->image);
                                    $publicPath = public_path( 'assets/images/' . $house->image);
                                    if (!empty($house->image) && file_exists($storagePath)) {
                                        $imageUrl = asset('storage/' . $house->image);
                                    } elseif (!empty($house->image) && file_exists($publicPath)) {
                                        $imageUrl = asset( 'assets/images/' .$house->image);
                                    }else {
                                        $imageUrl =asset('assets/images/' .'publishing_houses/defualt.jpg' );
                                    }      
                                @endphp
                                <img src="{{ $imageUrl }}"  width="50" height="50" class="rounded-circle">
                         
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                    <i class="fas fa-building text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $house->name }}</td>
                        <td>{{ $house->location }}</td>
                        <td>
                            <a href="{{ $house->website }}" target="_blank">{{ $house->website }}</a>
                        </td>
                        <td>{{ $house->books_count }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.publishing-houses.edit', $house->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.publishing-houses.destroy', $house->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No publishing houses found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $publishingHouses->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
</div>
@endsection