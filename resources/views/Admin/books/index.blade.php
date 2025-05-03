@extends('layouts.admin')

@section('admin-title')
  Mange Books
@endsection
@section('admin-styles')
<style>

    .filter-container {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 0.25rem;
        margin-bottom: 1.5rem;
    }
    .btn-orange{
        background:#FF5C28;
        color:white
    }
    .btn-orange:hover{
        border:1px solid #FF5C28;
        color:#FF5C28
    }

</style>
@endsection

@section('admin-content')
<div class="container-fluid">
    <div class="filter-container d-flex justify-content-between align-items-center">
      
    <strong class="mb-0">Books Management</strong>
        <a href="{{ route('admin.books.create') }}" class="btn btn-orange">
            <i class="fas fa-plus"></i> Add Book
        </a>
    </div>
<div class="card">
   
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th>Creator</th>
                        <th>Status</th>

                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>
                            @if($book->image)
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
                                <img src="{{ $imageUrl }}" width="50" height="70" class="img-thumbnail">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:70px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author?->name ?? 'N/A' }}</td>
                        <td>{{ $book->category?->name }}</td>
                        <td>{{ $book->publish_date->format('M d, Y') }}</td>
                        <td>{{ $book->publisher?->name }}</td>
                        <td>
                        @if($book->is_published == 'accepted')
                                <span class="badge bg-success">{{ $book->is_published }}</span>
                            @elseif($book->is_published == 'rejected')
                                <span class="badge bg-danger">{{ $book->is_published }}</span>
                            @else 
                                <span class="badge bg-warning">{{ $book->is_published }}</span>
                            @endif
                            </td>

                        <td>
                            @if($book->is_featured)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.audio-versions.create', ['book_id' => $book->id]) }}" 
                                   class="btn btn-sm btn-primary" title="Add Audio Version">
                                    <i class="fas fa-headphones"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                 
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $books->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
</div>

@endsection