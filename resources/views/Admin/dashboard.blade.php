@extends('layouts.admin')

@section('admin-title')
  Admin Dashboard
@endsection
@section('admin-nav-title')
  Dashboard
@endsection
@section('admin-styles')
<style>
    .card {
        border-radius: 0.35rem;
    }
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }
    .badge-warning {
        color: #212529;
    }
</style>
@endsection
@section('admin-content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Stats Cards -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Books</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_books'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Books appear in home</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['books_appear_in_home_page'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                               Featured Books</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['featured_books'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pen fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            EBooks Versions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['ebooks'] }}</div>
                        </div>
                        <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Audio Versions</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['audio_versions'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-headphones fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Books Section -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Books</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                 <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBooks as $book)
                                <tr>
                                    <td>{{ $book->title }}</td>
                                    <td>
                                        @if($book->is_published =='accepted')
                                            <span class="badge bg-warning">Published</span>
                                        @elseif($book->is_published =='rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else($book->is_published =='waiting')
                                            <span class="badge bg-success">Waiting</span>
                                        @endif
                                    </td>                                    </td>
                                    <td>{{ $book->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No books found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Audio Versions Section -->
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Audio Versions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Language</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentAudio as $audio)
                                <tr>
                                    <td>{{ $audio->book->title ?? 'N/A' }}</td>
                                    <td>{{ strtoupper($audio->language) }}</td>
                                    <td>{{ $audio->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No audio versions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('admin-scripts')
<script>
    // You can add any dashboard-specific JavaScript here
    $(document).ready(function() {
        console.log('Admin dashboard loaded');
    });
</script>
@endsection