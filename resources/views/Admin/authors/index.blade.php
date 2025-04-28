@extends('layouts.admin')

@section('admin-title')
   Mange Authors
@endsection


@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@section('admin-nav-title')
Mange Authors
@endsection</h5>
        <a href="{{ route('admin.authors.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Author
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Bio</th>
                        <th>Books Count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                    <tr>
                        <td>
                            @if($author->image)
                                <img src="{{ asset('storage/'.$author->image) }}" width="50" height="50" class="rounded-circle">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width:50px;height:50px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $author->name }}</td>
                        <td>{{ Str::limit($author->bio, 50) }}</td>
                        <td>{{ $author->books_count }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.authors.show', $author->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.authors.edit', $author->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.authors.destroy', $author->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                  
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $authors->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection