@extends('layouts.admin')

@section('admin-title', 'Review Details')
@section('admin-nav-title', 'Review Details')

@section('admin-content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Review Details</h5>
        <div>
            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Book</label>
                    <div class="form-control-plaintext">
                        <a href="{{ route('admin.books.show', $review->book_id) }}">
                            {{ $review->book->title }}
                        </a>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">User</label>
                    <div class="form-control-plaintext">
                        {{ $review->user->name }}
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="form-control-plaintext">
                        
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star{{ $i <= $review->rating ? '' : '-empty' }}"></i>
                            @endfor
                            <span class="ms-2">{{ $review->rating }}/5</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <div class="form-control-plaintext">
                        {{ $review->created_at->format('M d, Y \a\t h:i A') }}
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <div class="mb-3">
                    <label class="form-label">Comment</label>
                    <div class="card p-3">
                        {{ $review->comment }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection