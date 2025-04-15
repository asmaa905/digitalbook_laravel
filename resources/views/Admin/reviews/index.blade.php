@extends('layouts.admin')

@section('admin-title', 'Manage Reviews')
@section('admin-nav-title', 'Book Reviews Management')

@section('admin-styles')
<style>
    .rating-stars {
        color: #ffc107;
    }
    .review-card {
        border-left: 4px solid #ffc107;
    }
</style>
@endsection

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">All Reviews</h5>
      
    </div>
    
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="rating" class="form-label">Filter by Rating</label>
                    <select name="rating" id="rating" class="form-select">
                        <option value="">All Ratings</option>
                        @for($i=1; $i<=5; $i++)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label for="book_id" class="form-label">Filter by Book</label>
                    <select name="book_id" id="book_id" class="form-select">
                        <option value="">All Books</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ request('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="user_id" class="form-label">Filter by User</label>
                    <select name="user_id" id="user_id" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Book</th>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->id }}</td>
                        <td>
                            <a href="{{ route('admin.books.show', $review->book_id) }}">
                                {{ Str::limit($review->book->title, 30) }}
                            </a>
                        </td>
                        <td>{{ $review->user->name }}</td>
                        <td>
                            <div class="rating-stars">
                            {{$review->rating  }} <i class="fas fa-star"></i>
                            </div>
                        </td>
                        <td>{{ Str::limit($review->comment, 50) }}</td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                              
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST">
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
                        <td colspan="7" class="text-center">No reviews found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $reviews->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection