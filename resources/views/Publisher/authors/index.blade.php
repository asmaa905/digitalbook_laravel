@extends('layouts.publisher')

@section('title', 'Manage Authors')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Authors Management</h5>
        <a href="{{ route('publisher.authors.create') }}" class="btn btn-primary">
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
                    @forelse($authors as $author)
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
                                <a href="{{ route('publisher.authors.show', $author->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('publisher.authors.edit', $author->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('publisher.authors.destroy', $author->id) }}" method="POST">
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
                        <td colspan="5" class="text-center">No authors found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $authors->links() }}
        </div>
    </div>
</div>
@endsection