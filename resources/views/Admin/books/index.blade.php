@extends('layouts.admin')

@section('admin-title')
  Mange Books
@endsection
@section('admin-nav-title')
  Mange Books
@endsection

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Books Management</h5>
        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Book
        </a>
    </div>
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td>
                            @if($book->image)
                                <img src="{{ asset('storage/'.$book->image) }}" width="50" height="70" class="img-thumbnail">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:70px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author->name ?? 'N/A' }}</td>
                        <td>{{ $book->category->name }}</td>
                        <td>{{ $book->publish_date->format('M d, Y') }}</td>
                        <td>
                            @if($book->is_featured)
                                <span class="badge bg-success">Featured</span>
                            @else
                                <span class="badge bg-secondary">Regular</span>
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
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection