@extends('layouts.user')

@section('user-title')
  Categories
@endsection

@section('user-styles')
<style>
    /* Custom CSS for Storytel-like design */
    :root {
        --primary-color: #00a8e1;
        --secondary-color: #ff6b6b;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .categories-header {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 3rem 0;
        margin-bottom: 2rem;
    }
    
    .category-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        background: white;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .category-header {
        background-color: var(--primary-color);
        color: white;
        padding: 1.5rem;
        cursor: pointer;
    }
    
    .category-body {
        padding: 1.5rem;
        display: none; /* Initially hidden */
    }
    
    .books-list {
        list-style: none;
        padding: 0;
        margin-top: 1rem;
    }
    
    .books-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
        transition: all 0.2s ease;
    }
    
    .books-list li:hover {
        background-color: #f8f9fa;
        padding-left: 10px;
    }
    
    .books-list li:last-child {
        border-bottom: none;
    }
    
    .books-list a {
        color: var(--dark-color);
        text-decoration: none;
        display: flex;
        align-items: center;
    }
    
    .books-list a:hover {
        color: var(--primary-color);
    }
    
    .book-year {
        font-size: 0.8rem;
        color: #6c757d;
        margin-left: auto;
    }
    
    .empty-category {
        color: #6c757d;
        font-style: italic;
    }
    
    /* Animation for category expansion */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .category-expanded .category-body {
        display: block;
        animation: fadeIn 0.3s ease-out;
    }
    
    /* Responsive grid */
    @media (min-width: 768px) {
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
    }
    
    /* Search/filter styling */
    .categories-search {
        margin-bottom: 2rem;
        position: relative;
    }
    
    .categories-search input {
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        border: 1px solid #ddd;
        width: 100%;
        font-size: 1rem;
    }
    
    .categories-search i {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
    }
</style>
@endsection

@section('user-content')
<div class="categories-header">
    <div class="container" style="padding-top:100px">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-4 mb-3">Browse Categories</h1>
                <p class="lead">Discover books by genre, topic, or mood</p>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-outline-light btn-lg">Popular Categories</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="categories-search">
        <input type="text" id="categorySearch" placeholder="Search categories...">
        <i class="fas fa-search"></i>
    </div>
    
    <div class="categories-grid">
        @foreach($categories as $category)
        <div class="category-card">
            <div class="category-header" onclick="toggleCategory(this)">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="h4 mb-0">{{ $category->name }}</h2>
                    <span class="badge bg-light text-dark">{{ $category->books_count ?? $category->books->count() }}</span>
                </div>
            </div>
            <div class="category-body">
                @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
                @endif
                
                @if($category->books->count() > 0)
                <h5 class="mt-3">Popular in this category</h5>
                <ul class="books-list">
                    @foreach($category->books->take(5) as $book)
                    <li>
                        <a href="{{ route('user.books.show', $book->id) }}">
                            {{ $book->title }}
                            <span class="book-year">
                                {{ \Carbon\Carbon::parse($book->publish_date)->format('Y') }}
                            </span>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @if($category->books->count() > 5)
                <div class="text-center mt-3">
                    <a href="#" class="btn btn-sm btn-outline-primary">View all {{ $category->books->count() }} books</a>
                </div>
                @endif
                @else
                <p class="empty-category">No books available in this category yet.</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('user-scripts')
<script>
    // Toggle category expansion
    function toggleCategory(element) {
        const card = element.closest('.category-card');
        card.classList.toggle('category-expanded');
        
        // Close other open categories if needed
        // document.querySelectorAll('.category-card').forEach(el => {
        //     if (el !== card) el.classList.remove('category-expanded');
        // });
    }
    
    // Search/filter functionality
    document.getElementById('categorySearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const categories = document.querySelectorAll('.category-card');
        
        categories.forEach(category => {
            const name = category.querySelector('.category-header h2').textContent.toLowerCase();
            if (name.includes(searchTerm)) {
                category.style.display = 'block';
            } else {
                category.style.display = 'none';
            }
        });
    });
    
    // Optional: Auto-expand first category
    document.addEventListener('DOMContentLoaded', function() {
        const firstCategory = document.querySelector('.category-card');
        if (firstCategory) {
            firstCategory.classList.add('category-expanded');
        }
    });
</script>
@endsection