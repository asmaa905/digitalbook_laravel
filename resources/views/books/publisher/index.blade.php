@extends('layouts.user')

@section('user-content')
<div class="container">
    <h1>My Published Books</h1>
    
    <a href="#" class="btn btn-primary mb-3">
        Publish New Book
    </a>
    
    @if($publishedBooks->isEmpty())
        <div class="alert alert-info">
            You haven't published any books yet.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Published Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publishedBooks as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author->name }}</td>
                            <td>{{ $book->created_at->format('M d, Y') }}</td>
                            <td>
                                <span class="badge {{ $book->is_published == 'accepted'? 'bg-success' : ($book->is_published == 'waiting'?'bg-warning':'bg-danger') }}">
                                {{ $book->is_published == 'accepted'? 'Published' : ($book->is_published == 'waiting'?'waiting':'Rejected') }}
                                </span>
                                <span class="badge {{ $book->is_draft == true? 'bg-success':''}}">
                                {{ $book->is_draft == true?? Draft}}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $publishedBooks->links() }}
    @endif
</div>
@endsection