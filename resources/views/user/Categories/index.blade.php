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
    
            body {
                font-family: "Euclid Circular A", sans-serif;
                background: rgb(255, 251, 250);
            }
            img,
            svg {
                vertical-align: unset;
            }
            @media (min-width: 992px) {
                .col-lg-12-8 {
                    flex: 0 0 auto;
                    width: calc(12.5% - 8px) !important;
                }
            }
            /* @media (min-width: 1200px) {
                .container,
                .container-lg,
                .container-md,
                .container-sm,
                .container-xl {
                    max-width: 1297px;
                }
            } */
            @media (min-aspect-ratio: 4 / 5) {
                .jASifu {
                    background-image: url(https://images.ctfassets.net/eukfsb1ndh2n/4zMIdOhEn4NazgHJVCq1IP/7cbbe41…/expiration_date_2026_11_20_kayla-bed-phone_16-9.jpg?fm=webp&w=1920);
                }
            }

            @media (min-aspect-ratio: 1 / 2) {
                .jASifu {
                    background-image: url(https://images.ctfassets.net/eukfsb1ndh2n/6uHy3wT7o0F05y5t0JrQ3N/26b40ed…/e-books_page_1080x1080_1_x_1_1080_x1080_.jpg?fm=webp&w=768);
                }
            }
            .jASifu {
                display: flex;
                flex-direction: column;
                position: relative;
                width: 100%;
                background-repeat: no-repeat;
                background-size: cover;
                min-height: calc(100vh - 6.4rem);
                background-color: rgb(255, 242, 241);
                background-image: url(../../../../assets/images/banner-1.jpg);
                background-position: center center;
            }
            @media screen and (min-width: 600px) {
                .cJhNxu {
                    background-size: 100%;
                    padding: 5.6rem 3.2rem 3.2rem;
                }
            }
            .cJhNxu {
                z-index: 1;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                grid-column: 2 / 3;
                grid-row-start: 2;
                margin-top: auto;
                padding: 5.6rem 1.6rem 3.2rem;
                background-image: linear-gradient(
                    rgba(16, 16, 16, 0) 0%,
                    rgb(16, 16, 16) 66.37%
                );
                background-size: 100%;
            }
            .content {
                /* padding: 0 0 50px 16px; */
            }
            .main-title {
                font-style: normal;
                font-weight: 600;
                color: rgb(255, 80, 28);
                font-size: 83px;
                line-height: 81px;

                letter-spacing: -1.328px;
                text-decoration: none;
            }
            .head-desc {
                font-style: normal;
                font-weight: 400;
                color: #fff;
                font-size: 20px;
                line-height: 28px;
                text-decoration: none;
            }
            .try-btn {
                font-weight: 600;
                min-width: 10ch;
                border-radius: 1000px;
                padding: 5px 16px;
                color: rgb(16, 16, 16) !important;
                background-color: rgb(255, 255, 255);
                transition: all 0.3s;
                text-decoration: none;
            }

            .try-btn:hover {
                color: rgb(16, 16, 16) !important;
                background-color: rgb(242, 238, 235);
                transform: translateY(-1px);
            }

            ul li {
                text-decoration: none;
                list-style: none;
            }
            ul.lfjSpC {
                padding-top: 32px;
                padding-bottom: 27px;
                padding-left: 0.75rem;
            }
            ul.lfjSpC li a {
                font-weight: 500;
                font-style: normal;
                color: rgb(92, 92, 92) !important;
                font-size: 16px;
                line-height: 22px;
                transition: all 1s ease-in-out;
            }
            ul.lfjSpC li a:hover {
                color: rgb(198, 70, 27) !important;
            }
            .iXioEf {
                grid-area: 2 / 1 / 3 / -1;
                margin: 0px;
            }

            .kmnDis {
                width: 100%;
                height: 0.1rem;
                background: rgb(220, 213, 205);
                border: none;
            }
            .cat {
                text-decoration: none;
            }
            .cat:hover {
                /* border: 1px solid #000; */
            }
            .content {
                overflow: hidden;
                display: flex;
                flex-direction: column;
                row-gap: 16px;
                padding: 12px;
                background-color: rgb(255, 255, 255);
                border: 1px solid rgb(232, 232, 232);
                border-radius: 0.8rem;
                cursor: pointer;
                transition: border 0.2s ease-in-out;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                row-gap: 16px;
                padding: 12px;
                background-color: rgb(255, 255, 255);
                border: 1px solid rgb(232, 232, 232);
                border-radius: 0.8rem;
                cursor: pointer;
                gap: 10px;
                justify-content: center;
                transition: border 0.2s ease-in-out;
            }
            .content:hover {
                border: 1px solid rgb(105, 105, 105);
            }
            .cat-title {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                max-height: 3em;
                overflow: hidden;
                word-break: break-word;
                /* min-width: 3ch; */
                color: rgb(16, 16, 16);
                font-size: 28px;
                line-height: 40px;
                font-weight: 600;
                letter-spacing: -0.18px;
                font-weight: 600;
                text-decoration: none;
            }
            .cat .image {
                border-radius: 4px;
            }
            .cat-sections {
                /* gap: 24px; */
                display: flex;
            }
</style>
@endsection

@section('user-content')

<div class="hero">
            <div class="sc-1c680e04-0 jASifu">
                <div class="cJhNxu">
                    <h1 class="main-title">Categories</h1>
                    <p class="head-desc w-75">
                        Looking for specific book categories? You’ve come to the
                        right place. Browse among 18 genres to find the story
                        that’s right for you.
                    </p>
                    <a class="try-btn" href="#"> Try it Now </a>
                </div>
            </div>
        </div>
        <div class="main-sections mb-5">
            <div class="container p-0">
                <nav>
                    <ul class="sc-db0b2c15-0 lfjSpC">
                        <li class="sc-e408b72-0 cJEgpJ sc-db0b2c15-1 gAVRKW">
                            <a
                                href="{{route('user.home')}}"
                                class="sc-e408b72-0 kAwrBF"
                                >Home</a
                            >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="4"
                                height="7"
                                viewBox="0 0 5 8"
                                fill="#767676ff"
                            >
                                <path
                                    d="m1.144.864 2.681 2.663A.73.73 0 0 1 4.022 4a.702.702 0 0 1-.196.474L1.144 7.137a.67.67 0 0 1-.73.145C.163 7.178 0 6.971 0 6.682V1.337A.67.67 0 0 1 1.144.864Z"
                                ></path>
                            </svg>
                            <a
                                href="{{route('user.home')}}"
                                class="sc-e408b72-0 kAwrBF"
                                >Categories</a
                            >
                        </li>
                    </ul>
                </nav>
                <div class="cat-sections row m-0 p-0">
                @foreach($categories as $category)

                    <a class="cat col-md-6 g-3" href="{{route('user.categories.show',$category->id)}}">
                        <div class="content">
                            <div class="d-flex justify-content-between"> <h3 class="cat-title m-0">{{ $category->name }}</h3>
                            <span class="badge  text-dark">count ({{ $category->books_count ?? $category->books->count() }})</span>
</div>
                           
                            <hr
                                class="sc-64cd9d57-1 kmnDis sc-a754c39c-4 iXioEf"
                            />
                            <div class="cat-books row px-2">
                                @if($category->books->count() > 0)
                                    @foreach($category->books->take(6) as $book)
                                        <div class="col-2 p-0">
                                            <div
                                                class="image"
                                                style="
                                                    width: 90%;
                                                    height: 80%;
                                                    border-radius: 4px;
                                                "
                                            >
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
                                                <img
                                                     src="{{ $imageUrl }}"
                                                    alt="parwaaz"
                                                    class="w-100 h-100"
                                                />
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                @else
                                   <p class="empty-category text-dark">No books available in this category yet.</p>
                                @endif
                            </div>
                        </div>
                    </a>
                    @endforeach

                </div>
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