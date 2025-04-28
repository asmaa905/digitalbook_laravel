@extends('layouts.profile-layout')

@section('page-title', 'My Books -')
@section('page-styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('assets/css/postbook.css')}}" />
@endsection

@section('page-header-cont')
<h1>My Books</h1>
<p class="account-name">Manage your published ebooks and audiobooks</p>
@endsection

@section('page-content')
<div class="card">
    <div class="card-header ">
        
    @auth
                @if(count(auth()->user()->publishedBooks) >= 5  && !auth()->user()->hasActiveSubscription)
                   <p>You have reached the maximum books you can publish, <a href="{{ route('publisher.subscriptions.plans') }}">subscribe now to publish more</a></p>
                   @endif

                   @endauth 
                   <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">My Books</h5>
        <div class="d-flex flex-column justify-content-between align-items-center">
<div>
            @auth
                @if(count(auth()->user()->publishedBooks) < 5  || auth()->user()->hasActiveSubscription)
            <a href="{{ route('publisher.books.create') }}" class="btn bg-orange">
                <i class="fas fa-plus"></i> Add Book
            </a>
                @else
                <button  class="btn btn-orange btn-secondary" disabled> Subscribe to publish</button>
                     @endif
                
                @if(count(auth()->user()->audioVersionsCreated) < 5   || auth()->user()->hasActiveSubscription)
            <a href="{{ route('publisher.audio-versions.create') }}" class="btn bg-orange">
                <i class="fas fa-plus"></i> Add Audio Version
            </a>
                @else
                <button  class="btn btn-orange btn-secondary" disabled> Subscribe to publish</button>
                @endif
            @endauth
          
        </div>   
        </div>   
                   </div>
     
      
    </div>
    
    <div class="card-body">
        <ul class="nav nav-tabs" id="booksTabs" role="tablist">
        <li class="nav-item">
              <button type="button"  class="nav-link text-dark active" id="published-tab" data-bs-toggle="tab"  data-bs-target="#published" role="presentation">Published</button>
            </li>
            <li class="nav-item">
              <button type="button"  class="nav-link text-dark" id="waiting-tab" data-bs-toggle="tab"  data-bs-target="#waiting" role="presentation">Waiting</button>
            </li>
            
            <li class="nav-item">
              <button type="button"  class="nav-link text-dark" id="rejected-tab" data-bs-toggle="tab"  data-bs-target="#rejected" role="presentation">Rejected</button>
            </li>
          
            <li class="nav-item">
              <button type="button" class="nav-link text-dark" id="audio-tab" data-bs-toggle="tab"  data-bs-target="#audio" role="presentation">Audio Versions</button>
            </li>

        </ul>
        
        <div class="tab-content" id="booksTabsContent">
            <!-- Published Books Tab -->
            <div class="tab-pane fade show active" id="published" role="tabpanel">
            @include('publisher.books.partials.books-table', [
                    'books' => $publishedBooks,
                    'type' => 'published'
                ])
            </div>
            <!-- waiting Books Tab -->
            <div class="tab-pane fade" id="waiting" role="tabpanel">
                @include('publisher.books.partials.books-table', [
                    'books' => $waitingBooks,
                    'type' => 'waiting'
                ])
            </div>
            <!-- rejected Books Tab -->
            <div class="tab-pane fade" id="rejected" role="tabpanel">
                @include('publisher.books.partials.books-table', [
                    'books' => $rejectedBooks,
                    'type' => 'rejected'
                ])
            </div>
          

            <!-- Audio Versions Tab -->
            <div class="tab-pane fade" id="audio" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Title</th>
                                <th>Narrator</th>
                                <th>Duration</th>
                                <th>Review Audio</th>

                                <th>Full Audios</th>

                                <th>Audio Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($audioVersions as $audio)
                            <tr>
                                <td>
                                    @if($audio->book->image)
                                        <img src="{{ asset('storage/'.$audio->book->image) }}" width="50" height="70" class="img-thumbnail">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width:50px;height:70px;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $audio->book->title }}</td>
                                <td>{{ $audio->creator->name ?? 'Unknown' }}</td>
                                <td>{{ $audio->audio_duration }}</td>
                                <td><span class="badge bg-success">
                                    Found
                                    </span></th>

                                <td>
                                @if($audio->audio_link)
                                        <audio controls style="width: 150px">
                                            <source src="{{ asset('storage/'.$audio->audio_link) }}" type="audio/{{ pathinfo($audio->audio_link, PATHINFO_EXTENSION) }}">
                                        </audio>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif 
                               </td>
                                <td>
                                    <span class="badge bg-{{ $audio->is_published === 'accepted' ? 'success' : ($audio->is_published === 'rejected' ? 'danger' : 'info') }}">
                                        {{ ucfirst($audio->is_published) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('publisher.audio-versions.show', $audio->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('publisher.audio-versions.edit', $audio->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('publisher.audio-versions.destroy', $audio->id) }}" method="POST">
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
                                <td colspan="8" class="text-center">No audio versions found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $audioVersions->links('pagination::bootstrap-5') }}
                </div>
            </div>


                    </div>
                </div>
            </div>
@endsection
@section('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if we have a hash in the URL
        const hash = window.location.hash;
    
        // If hash is present and matches a tab, activate it
        if(hash) {
            const triggerEl = document.querySelector(`.nav-tabs button[data-bs-target="${hash}"]`);
            if(triggerEl) {
            // Remove active class from all tabs and panes
            document.querySelectorAll('.nav-tabs .nav-link').forEach(el => {
                el.classList.remove('active');
            });
            document.querySelectorAll('.tab-pane').forEach(el => {
                el.classList.remove('show', 'active');
            });
            
            // Add active class to the target tab and pane
            triggerEl.classList.add('active');
            const targetPane = document.querySelector(hash);
            if(targetPane) {
                targetPane.classList.add('show', 'active');
            }
            }
        }
        
        // Change hash for page-reload
        const tabEls = document.querySelectorAll('.nav-tabs button[data-bs-toggle="tab"]');
        tabEls.forEach(tabEl => {
            tabEl.addEventListener('shown.bs.tab', function(e) {
                window.location.hash = e.target.getAttribute('data-bs-target');
            });
        });
    });
</script>
@endsection