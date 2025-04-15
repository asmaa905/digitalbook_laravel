@extends('layouts.user')

@section('user-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
               
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#dc3545" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                        </svg>
                    </div>
                    <h3 class="text-danger mb-3">Payment Unsuccessful</h3>
                    <p class="lead">Dear {{ auth()->user()->name }}, we couldn't process your payment.</p>
                    <p>Error: {{ $errorMessage ?? 'Unknown error occurred' }}</p>
                    <p>We'll notify you at {{ auth()->user()->email }} if we receive updates.</p>
                    
                    <div class="mt-5">
                        <a href="{{ route('publisher.subscriptions.plans') }}" class="btn btn-dark">
                            View Available Plans
                        </a>
                       
                    </div>
                    
                    <div class="mt-4">
                        <p>Need help? Contact us at <a class="text-orange" href="mailto:support@example.com">support@example.com</a></p>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection