
@extends('layouts.user')

@section('user-title')
Home - 
@endsection
@section('user-styles')
    <style>
        .feature-list {
    list-style-type: none;
    padding-left: 0;
}

.feature-list li {
    position: relative;
    padding-left: 25px;
    margin-bottom: 8px;
}

.feature-list li:before {
    content: "✓";
    color: #28a745;
    position: absolute;
    left: 0;
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
        @media (min-width: 1200px) {
            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                max-width: 1297px;
            }
        }
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
            min-height: calc(100vh - 357px);
            background-color: rgb(255, 242, 241);
            background-image: url(assets/images/backgrounds/hero-home.JPG);
            background-position: top top;
            padding-top: 50px;
            height: 90%;
        }
        @media screen and (min-width: 600px) {
            .cJhNxu {
                background-size: 100%;
                padding: 5.6rem 3.2rem 3.2rem;
            }
        }
        .cJhNxu {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            grid-column: 2 / 3;
            grid-row-start: 2;
            margin-top: auto;
            padding: 1rem 1.6rem 3rem;
            background-image: linear-gradient(
                rgba(16, 16, 16, 0) 0%,
                rgb(16, 16, 16) 66.37%
            );
            background-size: 100%;
        }
        .content {
            padding: 0 0 0 16px;
            width: 62% !important;
        }
        .main-title {
            font-style: normal;
            font-weight: 600;
            color: rgb(255, 80, 28);
            font-size: 72px;
            line-height: 74px;

            letter-spacing: -1.328px;
            text-decoration: none;
        }
        .head-desc {
            font-style: normal;
            font-weight: 400;
            color: #fff;
            font-size: 16px;
            line-height: 22px;
            text-decoration: none;
            margin-bottom: 2rem;
        }
        .try-btn-head {
            font-weight: 600;
            min-width: 10ch;
            border-radius: 1000px;
            padding: 5px 16px;
            color: rgb(16, 16, 16) !important;
            background-color: rgb(255, 255, 255);
            transition: all 0.3s;
            text-decoration: none;
            margin-top: 5px;
        }

        .try-btn-head:hover {
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
        .books-all-sections {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .books-section {
            row-gap: 2.4rem;
            padding-top: 0px;
            padding-bottom: 4rem;
            background-color: rgb(255, 251, 250);
        }
        .sec-title {
            font-weight: 600;
            font-style: normal;
            color: rgb(16, 16, 16) !important;
            font-size: 26px;
            line-height: 32px;
            text-decoration-line:none
        }
        .cards {
            gap: 8px;
        }
        .sec-title:hover {
            text-decoration-line: underline;
            cursor: pointer;
        }
        .all-books-link {
            font-weight: 600;
            font-style: normal;
            color: rgb(16, 16, 16) !important;
            font-size: 13px;
            line-height: 16px;
            transition: all 1s ease-in-out;
        }
        .all-books-link:hover {
            text-decoration-line: underline;
        }
        .all-books-link span {
            padding-right: 5px;
        }
        .book-card {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            gap: 0.5rem;
            border: 0.8px solid #ccc;
            width: 166.4px;
            height: 250px;

            border-radius: 4rem;
            padding: 8px;
        }
        .book-card .image {
            aspect-ratio: 1 / 1;
        }
        .book-card .card-title {
            font-weight: 600;
            font-style: normal;
            color: rgb(16, 16, 16) !important;
            font-size: 13px;
            line-height: 16px;
            transition: all 1s ease-in-out;
        }
        .book-card .card-text {
            font-weight: 400;
            font-style: normal;
            color: rgb(92, 92, 92) !important;
            font-size: 13px;
            line-height: 16px;
            transition: all 1s ease-in-out;
        }
        .book-card .actions {
            padding-top: 25px;
        }
        .book-card .actions .rates {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .book-card .actions .rates,
        .book-card .actions .pdf-version,
        .book-card .actions .audio-version {
            width: 32px;
            height: 16px;
        }
        .book-card .actions .rates img,
        .book-card .actions .pdf-version img,
        .book-card .actions .audio-version img {
            width: 100%;
            height: 100%;
        }

        .book-card .actions .rate-avg {
            color: rgb(92, 92, 92) !important;
            font-size: 13px;
            line-height: 16px;
        }
        .offers li {
            color: rgb(92, 92, 92) !important;
            font-weight: 400;
            font-style: normal;
            font-size: 16px;
            line-height: 22px;
        }
        .subscribtion {
            padding: 2rem;
        }
        .subscribe-head {
            width: 100%;
            width: 580px;
            margin: 0px auto 4rem;
            display: flex;
            flex-direction: column;
            gap: 1.6rem;
        }

        .plan-features {
            margin: 1.5rem 0;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .feature-item i {
            color: #ff5c28;
            margin-right: 0.75rem;
        }

        .plan-price {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin: 1rem 0;
        }

        .price-period {
            font-size: 1rem;
            font-weight: 400;
            color: #666;
        }

        .try-btn {
            cursor: pointer;
            min-width: 10ch;
            border-width: 0px;
            border-radius: 1000px;
            border-color: transparent;
            text-align: center;
            font-size: 1.6rem;
            text-decoration: none;
            font-style: normal;
            font-stretch: normal;
            letter-spacing: -0.16px;
            line-height: 2.4rem;
            min-height: 4.8rem;
            padding: 1.2rem 2rem;
            background-color: rgb(16, 16, 16);

            font-weight: 500;
            color: rgb(255, 255, 255);
            font-size: 14px;
            line-height: 24px;
            font-style: normal;
            padding: 10px 132px;
        }

        .try-btn:hover {
            /* background-color: #e04b20; */
            color: rgb(255, 255, 255);
            background-color: rgb(51, 51, 51);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #ff5c28;
            color: #ff5c28;
        }

        .btn-outline:hover {
            background: rgba(255, 92, 40, 0.1);
        }
       /* subscribtions data */
       .plans-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }
    
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    
    .plan-card {
        border-radius: 12px;
        padding: 2rem;
        background: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        position: relative;
        transition: transform 0.3s ease;
    }
    
    .plan-card:hover {
        transform: translateY(-5px);
    }
    
    .plan-card.highlighted {
        border: 2px solid #ff5c28;
        transform: scale(1.02);
    }
    
    .highlight-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: #ff5c28;
        color: white;
        padding: 0.25rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 1;
    }
    
    .plan-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .plan-price {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
        color: #ff5c28;
    }
    
    .price-period {
        font-size: 1rem;
        color: #666;
        font-weight: normal;
    }
    
    .free-demo {
        background: #FF9800;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 1rem;
        font-size: 0.8rem;
    }
    
    .plan-features {
        margin: 1.5rem 0;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .feature-item i {
        margin-right: 0.5rem;
        color: #ff5c28;
    }
    
    .btn-subscribe {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: none;
        border-radius: 6px;
        background: #ff5c28;
        color: white;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: 1rem;
    }
    
    .btn-subscribe:hover {
        background: #3e8e41;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-subscribe:disabled {
        background: #cccccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    
    .expiry-info {
        margin-top: 1rem;
        font-size: 0.9rem;
        color: #666;
        text-align: center;
    }
    
    .current-plan-badge {
        background: #2196F3;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
      

        .post-books .desc h2,
        .discover-without-limit .desc h2 {
            font-size: 74px;
            font-style: normal;
            line-height: 72px;
            color: rgb(255, 80, 28);
            font-weight: 600;
        }
        .post-books .desc p,
        .discover-without-limit .desc p {
            font-size: 16px;
            font-style: normal;
            line-height: 22px;
            color: rgb(92, 92, 92);
            font-weight: 400;
        }
        .post-books .desc .btn-sec:hover,
        .discover-without-limit .desc .btn-sec:hover {
            color: rgb(16, 16, 16);
            background-color: rgb(242, 238, 235);
        }
    </style>
@endsection

@section('user-content')
<div
            class="hero"
            style="
                padding-top: 4rem !important;
                background-color: rgb(16, 16, 16);
            "
        >
            <div class="sc-1c680e04-0 jASifu"></div>
            <div class="cJhNxu">
                <div class="content">
                    <h1 class="main-title">A complete audio library</h1>
                    <p class="head-desc">
                        Over 500,000 stories to listen to starting at
                        €9.99/month. Cancel anytime.
                    </p>
                    <a class="try-btn-head" href="#"> Try it for free </a>
                </div>
            </div>
        </div>
        <div class="main-sections" style="padding-top: 160px">
            <div class="container p-0">
                <section class="subscritions px-5">
                    <div class="subscribe-head">
                        <h2
                            style="
                                font-weight: 600;
                                color: rgb(255, 80, 28);
                                font-style: normal;
                                font-size: 72px;
                                line-height: 74px;
                            "
                        >
                            The Listen To Story offer:
                        </h2>
                        <ul
                            class="offers"
                            style="list-style: none; margin-bottom: 40px"
                        >
                            <li>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    fill="#5c5c5cff"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M21.581 5.42c.559.557.559 1.46 0 2.017l-11.429 11.43a1.425 1.425 0 0 1-2.018 0l-5.716-5.715a1.429 1.429 0 0 1 2.02-2.018l4.665 4.701 10.46-10.416a1.424 1.424 0 0 1 2.018 0Z"
                                    ></path>
                                </svg>
                                Publish any book.
                            </li>
                            <li>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    fill="#5c5c5cff"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M21.581 5.42c.559.557.559 1.46 0 2.017l-11.429 11.43a1.425 1.425 0 0 1-2.018 0l-5.716-5.715a1.429 1.429 0 0 1 2.02-2.018l4.665 4.701 10.46-10.416a1.424 1.424 0 0 1 2.018 0Z"
                                    ></path>
                                </svg>
                                Download or Listen over 600,000 titles at maximum speed and
                                without wainting to download it .
                            </li>
                            <li>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    fill="#5c5c5cff"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M21.581 5.42c.559.557.559 1.46 0 2.017l-11.429 11.43a1.425 1.425 0 0 1-2.018 0l-5.716-5.715a1.429 1.429 0 0 1 2.02-2.018l4.665 4.701 10.46-10.416a1.424 1.424 0 0 1 2.018 0Z"
                                    ></path></svg
                                >No Published Books limits.
                            </li>

                            <li>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    fill="#5c5c5cff"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M21.581 5.42c.559.557.559 1.46 0 2.017l-11.429 11.43a1.425 1.425 0 0 1-2.018 0l-5.716-5.715a1.429 1.429 0 0 1 2.02-2.018l4.665 4.701 10.46-10.416a1.424 1.424 0 0 1 2.018 0Z"
                                    ></path>
                                </svg>
                                Users will be able to download your uploaded
                                books without waiting.
                            </li>

                            <li>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    fill="#5c5c5cff"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M21.581 5.42c.559.557.559 1.46 0 2.017l-11.429 11.43a1.425 1.425 0 0 1-2.018 0l-5.716-5.715a1.429 1.429 0 0 1 2.02-2.018l4.665 4.701 10.46-10.416a1.424 1.424 0 0 1 2.018 0Z"
                                    ></path>
                                </svg>
                                No problems with the download links for your
                                uploaded books.
                            </li>
                            <li>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    fill="#5c5c5cff"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M21.581 5.42c.559.557.559 1.46 0 2.017l-11.429 11.43a1.425 1.425 0 0 1-2.018 0l-5.716-5.715a1.429 1.429 0 0 1 2.02-2.018l4.665 4.701 10.46-10.416a1.424 1.424 0 0 1 2.018 0Z"
                                    ></path>
                                </svg>
                                Downloads start with the click of a button
                                without waiting for the book to be ready.
                            </li>
                           
                        </ul>
                    </div>
                    
                    <div class="plans-grid d-flex justify-content-center">
                        @foreach($plans as $plan)
                            <div class="plan-card {{ $plan->is_featured ? 'highlighted' : '' }}">
                                @if($plan->is_featured)
                                    <span class="highlight-badge">Most Popular</span>
                                @endif
                                
                                <h3>{{ $plan->name }}</h3>
                                <div class="plan-price">
                                    @if($plan->price > 0)
                                        ${{ number_format($plan->price, 2) }}
                                        <span class="price-period">/ {{ $plan->plan_duration < 12 ? $plan->plan_duration.' month' : ($plan->plan_duration/12).' year' }}</span>
                                    @else
                                        ${{ number_format($plan->price, 2) }}<span class="price-period"> / unlimited</span>
                                    @endif
                                </div>
                                
                                @if($plan->free_trial_days > 0)
                                    <p class="free-demo">
                                        {{ $plan->free_trial_days }} days free trial
                                    </p>
                                @endif

                                <div class="plan-features">
                                <ul class="list-unstyled">
                                    @php
                                      if(is_array($plan->features) &&$plan->features[0]){
                                        $decodedFeatured = json_decode($plan->features[0]);
                                      }elseif(is_array($plan->features) ) {
                                        $decodedFeatured = json_decode($plan->features);
                                      }
                                    @endphp
                                    @foreach(  $decodedFeatured as $feature)
                                        <li class="mb-2">
                                            <i class="fas fa-check text-success me-2"></i>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                                </div>
                                
                                @php
                                    $userSubscription = null;
                                    $isActive = false;
                                    
                                    if (auth()->check()) {
                                        $userSubscription = auth()->user()->subscriptions()
                                            ->where('plan_id', $plan->id)
                                            ->where('status', 'confirm')
                                            ->latest()
                                            ->first();
                                            
                                        $isActive = $userSubscription && 
                                                ($userSubscription->end_date === null || 
                                                    $userSubscription->end_date->gt(now()));
                                    }
       
                                    // Check if user has any active subscription (from controller)
                                    $disableSubscribe = $hasActiveSubscription && !$isActive;
                                @endphp
                                
                                @if($plan->price != 0)
                                    @if($userSubscription && $isActive)
                                        <span class="current-plan-badge">Current Plan</span>
                                        <div class="expiry-info">
                                            @if($userSubscription->end_date)
                                                Expires in {{ intval(now()->diffInDays($userSubscription->end_date)) }} days
                                            @else
                                                No expiration date
                                            @endif
                                        </div>
                                        <button class="btn-subscribe" disabled>Already Subscribed</button>
                                    @elseif($userSubscription && !$isActive)
                                        <form action="{{ route('publisher.subscriptions.renew', $plan) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-subscribe">
                                                Renew Subscription
                                            </button>
                                        </form>
                                        <div class="expiry-info">
                                            Expired {{ $userSubscription->end_date ? $userSubscription->end_date->diffForHumans() : '' }}
                                        </div>
                                    @else
                                        <form action="{{ route('publisher.subscriptions.subscribe', $plan) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-subscribe" {{ $disableSubscribe ? 'disabled' : '' }}>
                                                Subscribe Now
                                            </button>
                                            @if($disableSubscribe)
                                                <div class="expiry-info mt-2">
                                                    You already have an active subscription
                                                </div>
                                            @endif
                                        </form>
                                    @endif
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
                <section
                    class="post-books row justify-content-between align-items-center py-5"
                >
                    <div class="book-imgs col-md-6">
                        <div class="">
                            <img
                            src="{{asset('assets/images/books/book-1.jpg')}}"
                            alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                    <div class="desc col-md-6">
                        <h2>Stories selected for you</h2>
                        <p>
                            Follow your favorite author, narrator, or series and
                            get personalized recommendations based on what
                            you've previously listened to.
                        </p>
                        <a
                            href="#"
                            class="try-btn btn-sec text-black bg-white"
                            style="border: 1px solid #000; padding: 5px 10px"
                            >Try it now</a
                        >
                    </div>
                </section>

                <section
                    class="discover-without-limit row justify-content-between align-items-center p-5"
                >
                    <div class="book-imgs col-md-6">
                        <div class="">
                            <img
                               src="{{asset('assets/images/books/book-5.png')}}"
                                alt=""
                                class="img-fluid"
                            />
                        </div>
                    </div>
                    <div class="desc col-md-6">
                        <h2>Anytime Anywhere</h2>
                        <p>
                            Listen to your books while you fall asleep or on the
                            go. Download your audio library and enjoy your
                            titles offline on your favorite devices.
                        </p>
                        <a
                            href="#"
                            class="try-btn btn-sec text-black bg-white"
                            style="border: 1px solid #000; padding: 5px 10px"
                            >Try it now</a
                        >
                    </div>
                </section>
                <div class="books-all-sections">
                    <!-- filter by top rated -->
                    <section class="books-section top-rated">
                            <div class="row px-0 mx-0">
                                <div
                                    class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                                >
                                    <a class="sec-title" style="" href="{{route('user.books.ebooks')}}">Top 50</a>
                                    <div class="all-books-link d-flex">
                                        <a style="color: #000; text-decoration-line:none" href="{{route('user.books.ebooks')}}"> View all titles</a>
                                        <div
                                            class="icon"
                                            style="width: 1rem; height: 1rem"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                style="width: 100%; height: 100%"
                                                fill="#101010"
                                                viewBox="0 0 15 28"
                                                class="sc-dd917b06-0 bAuqWJ"
                                            >
                                                <path
                                                    d="m2.895 1.126 11.35 11.846c.277.286.415.658.415 1.028s-.138.742-.415 1.028L2.895 26.874a1.483 1.483 0 0 1-2.101.045 1.48 1.48 0 0 1-.045-2.102l10.414-10.873L.751 3.184A1.48 1.48 0 0 1 .796 1.08a1.48 1.48 0 0 1 2.1.045Z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <!-- <i class="fas fa-greater-than"></i> -->
                                    </div>
                                </div>
                            </div>
                            <div class="cards row p-0 m-0">
                            @if($topRatedBooks->count() > 0)
                            @foreach($topRatedBooks as $book)
                                <a
                                    class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                                    style="border-radius: 5px;text-decoration-line:none"
                                    href="{{ route('user.books.show', $book->id) }}" 
                                >
                                    <div class="image"  style="width:95%;height:60%">
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
                                        alt="book"
                                        class="card-img-top w-100 h-100"
                                        />
                                    
                                    </div>

                                    <div class="card-body p-0">
                                        <h5 class="card-title pb-0 mb-0">
                                        @if (strlen($book->title) > 25)
                                            {{substr($book->title, 0, 25) . "..."}}
                                        @else 
                                        {{cutText($book->title)}} 
                                        @endif
                                        
                                        </h5>
                                        <p class="card-text pb-0 mb-0">
                                        {{$book->author? $book->author->name: 'unknown'}}
                                        </p>
                                        <div
                                            class="actions d-flex justify-content-between align-items-center"
                                        >
                                    
                                            <div class="rates p-0">
                                                <img
                                                    src="{{asset('assets/images/icons/star.svg')}}"
                                                    alt=""
                                                />
                                                <span class="rate-avg"> {{$book->rating}} </span>
                                            </div>
                                            <div
                                                class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                            >

                                            @if($book->audioVersions->count() > 0)

                                                <div class="audio-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/headphones.svg')}}"

                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                                @if($book->pdf_link)

                                                <div class="pdf-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/glasses.svg')}}"
                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                @endforeach
                                @endif

                            </div>
                        </section>
                    <!-- all books -->
                    <section class="books-section all-books">
                            <div class="row px-0 mx-0">
                                <div
                                    class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                                >
                                <a class="sec-title" style="" href="{{route('user.books.ebooks')}}">Explore the World of Books</a>
                                    <div class="all-books-link d-flex">
                                    <a style="color: #000; text-decoration-line:none" href="{{route('user.books.ebooks')}}"> View all titles</a>
                                    <div
                                            class="icon"
                                            style="width: 1rem; height: 1rem"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                style="width: 100%; height: 100%"
                                                fill="#101010"
                                                viewBox="0 0 15 28"
                                                class="sc-dd917b06-0 bAuqWJ"
                                            >
                                                <path
                                                    d="m2.895 1.126 11.35 11.846c.277.286.415.658.415 1.028s-.138.742-.415 1.028L2.895 26.874a1.483 1.483 0 0 1-2.101.045 1.48 1.48 0 0 1-.045-2.102l10.414-10.873L.751 3.184A1.48 1.48 0 0 1 .796 1.08a1.48 1.48 0 0 1 2.1.045Z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <!-- <i class="fas fa-greater-than"></i> -->
                                    </div>
                                </div>
                            </div>
                            <div class="cards row p-0 m-0">
                            @if($allBooks->count() > 0)
                            @foreach($allBooks as $book)
                                <a
                                    class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                                    style="border-radius: 5px;text-decoration-line:none"
                                    href="{{ route('user.books.show', $book->id) }}" >
                                    <div class="image" style="width:95%;height:60%">
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
                                        alt="book"
                                        class="card-img-top w-100 h-100"
                                        />
                                    
                                    </div>

                                    <div class="card-body p-0">
                                        <h5 class="card-title pb-0 mb-0">
                                        @if (strlen($book->title) > 25)
                                            {{substr($book->title, 0, 25) . "..."}}
                                        @else 
                                        {{cutText($book->title)}} 
                                        @endif
                                        
                                        </h5>
                                        <p class="card-text pb-0 mb-0">
                                        {{$book->author? $book->author->name: 'unknown'}}
                                        </p>
                                        <div
                                            class="actions d-flex justify-content-between align-items-center"
                                        >
                                    
                                            <div class="rates p-0">
                                                <img
                                                    src="{{asset('assets/images/icons/star.svg')}}"
                                                    alt=""
                                                />
                                                <span class="rate-avg"> {{$book->rating}} </span>
                                            </div>
                                            <div
                                                class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                            >

                                            @if($book->audioVersions->count() > 0)

                                                <div class="audio-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/headphones.svg')}}"

                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                                @if($book->pdf_link)

                                                <div class="pdf-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/glasses.svg')}}"
                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                @endforeach
                                @endif
                            </div>
                        </section>
                    <!-- all featured books -->
                    <section class="books-section featured-books">
                            <div class="row px-0 mx-0">
                                <div
                                    class="sec-header col-md-12 d-flex justify-content-between align-items-center"
                                >
                                <a class="sec-title" style="" href="{{route('user.books.ebooks')}}">Featured  Books</a>
                                    <div class="all-books-link d-flex">
                                    <a style="color: #000; text-decoration-line:none" href="{{route('user.books.ebooks')}}"> View all titles</a>
                                    <div
                                            class="icon"
                                            style="width: 1rem; height: 1rem"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                style="width: 100%; height: 100%"
                                                fill="#101010"
                                                viewBox="0 0 15 28"
                                                class="sc-dd917b06-0 bAuqWJ"
                                            >
                                                <path
                                                    d="m2.895 1.126 11.35 11.846c.277.286.415.658.415 1.028s-.138.742-.415 1.028L2.895 26.874a1.483 1.483 0 0 1-2.101.045 1.48 1.48 0 0 1-.045-2.102l10.414-10.873L.751 3.184A1.48 1.48 0 0 1 .796 1.08a1.48 1.48 0 0 1 2.1.045Z"
                                                ></path>
                                            </svg>
                                        </div>
                                        <!-- <i class="fas fa-greater-than"></i> -->
                                    </div>
                                </div>
                            </div>
                            <div class="cards row p-0 m-0">
                            @if( $isFeasuredBooks->count() > 0)
                            @foreach( $isFeasuredBooks as $book)
                            <a
                                    class="card border-1 book-card col-lg-12-8 col-md-2 col-sm-3 col-6"
                                    style="border-radius: 5px;text-decoration-line:none"
                                    href="{{ route('user.books.show', $book->id) }}" 
                                >
                                    <div class="image"  style="width:95%;height:60%">
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
                                        alt="book"
                                        class="card-img-top w-100 h-100"
                                        />
                                    
                                    </div>

                                    <div class="card-body p-0">
                                        <h5 class="card-title pb-0 mb-0">
                                        @if (strlen($book->title) > 25)
                                            {{substr($book->title, 0, 25) . "..."}}
                                        @else 
                                        {{cutText($book->title)}} 
                                        @endif
                                        
                                        </h5>
                                        <p class="card-text pb-0 mb-0">
                                        {{$book->author? $book->author->name: 'unknown'}}
                                        </p>
                                        <div
                                            class="actions d-flex justify-content-between align-items-center"
                                        >
                                    
                                            <div class="rates p-0">
                                                <img
                                                    src="{{asset('assets/images/icons/star.svg')}}"
                                                    alt=""
                                                />
                                                <span class="rate-avg"> {{$book->rating}} </span>
                                            </div>
                                            <div
                                                class="book-versions d-flex justify-content-between align-items-center col-3 p-0"
                                            >

                                            @if($book->audioVersions->count() > 0)

                                                <div class="audio-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/headphones.svg')}}"

                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                                @if($book->pdf_link)

                                                <div class="pdf-version">
                                                    <img
                                                    src="{{asset('assets/images/icons/glasses.svg')}}"
                                                        alt=""
                                                    />
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                @endforeach
                                @endif

                            </div>
                        </section>
                    
                            </div>
                        </div>
                    
                    
                </div>
@endsection

