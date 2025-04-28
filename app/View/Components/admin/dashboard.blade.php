@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Audio Ebook Dashboard</h1>
        <div>
            <a href="{{ route('admin.ebooks.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Add New Ebook
            </a>
            <a href="{{ route('admin.reports.generate') }}" class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm ml-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
            </a>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Ebooks Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Ebooks</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEbooks }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Downloads This Month Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Downloads (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $monthlyDownloads }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-download fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Revenue (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($monthlyRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Sales Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Sales Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Time Range:</div>
                            <a class="dropdown-item" href="#" data-range="7">Last 7 Days</a>
                            <a class="dropdown-item" href="#" data-range="30">Last 30 Days</a>
                            <a class="dropdown-item" href="#" data-range="90">Last Quarter</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-range="365">Annual</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Genres Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Popular Genres</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">View By:</div>
                            <a class="dropdown-item" href="#" data-view="downloads">Downloads</a>
                            <a class="dropdown-item" href="#" data-view="revenue">Revenue</a>
                            <a class="dropdown-item" href="#" data-view="count">Title Count</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="genresChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach($topGenres as $genre)
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color: {{ $genre->color }}"></i> {{ $genre->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Uploads -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Uploads</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Genre</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentEbooks as $ebook)
                                <tr>
                                    <td>{{ $ebook->title }}</td>
                                    <td>{{ $ebook->author->name }}</td>
                                    <td>{{ $ebook->genre->name }}</td>
                                    <td>{{ $ebook->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.ebooks.edit', $ebook->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.ebooks.show', $ebook->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No recent uploads</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent User Activities -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent User Activities</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Activity</th>
                                    <th>Ebook</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentActivities as $activity)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.users.show', $activity->user->id) }}">
                                            {{ $activity->user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $activity->action }}</td>
                                    <td>
                                        @if($activity->ebook)
                                        <a href="{{ route('admin.ebooks.show', $activity->ebook->id) }}">
                                            {{ $activity->ebook->title }}
                                        </a>
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>{{ $activity->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No recent activities</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- User Growth Stats -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Growth</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('admin.ebooks.index') }}" class="btn btn-block btn-primary">
                                <i class="fas fa-book-open mr-2"></i>Manage Ebooks
                            </a>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-block btn-success">
                                <i class="fas fa-users mr-2"></i>Manage Users
                            </a>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-block btn-info">
                                <i class="fas fa-credit-card mr-2"></i>Subscriptions
                            </a>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('admin.narrators.index') }}" class="btn btn-block btn-warning">
                                <i class="fas fa-microphone mr-2"></i>Narrators
                            </a>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-block btn-danger">
                                <i class="fas fa-star mr-2"></i>Reviews
                            </a>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-cog mr-2"></i>Platform Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sales Chart
    var ctx = document.getElementById("salesChart");
    var salesData = @json($salesData);
    
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.labels,
            datasets: [{
                label: "Sales",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: salesData.values,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function(value, index, values) {
                            return '$' + value;
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': $' + tooltipItem.yLabel;
                    }
                }
            }
        }
    });

    // Genres Chart
    var genreCtx = document.getElementById("genresChart");
    var genresData = @json($genresData);
    
    var genresChart = new Chart(genreCtx, {
        type: 'doughnut',
        data: {
            labels: genresData.labels,
            datasets: [{
                data: genresData.values,
                backgroundColor: genresData.colors,
                hoverBackgroundColor: genresData.hoverColors,
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });

    // User Growth Chart
    var userCtx = document.getElementById("userGrowthChart");
    var userData = @json($userGrowthData);
    
    var userGrowthChart = new Chart(userCtx, {
        type: 'line',
        data: {
            labels: userData.labels,
            datasets: [{
                label: "New Users",
                lineTension: 0.3,
                backgroundColor: "rgba(28, 200, 138, 0.05)",
                borderColor: "rgba(28, 200, 138, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(28, 200, 138, 1)",
                pointBorderColor: "rgba(28, 200, 138, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(28, 200, 138, 1)",
                pointHoverBorderColor: "rgba(28, 200, 138, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: userData.values,
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        beginAtZero: true
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
            }
        }
    });

    // Handle time range changes for sales chart
    $('.dropdown-item[data-range]').click(function(e) {
        e.preventDefault();
        var range = $(this).data('range');
        
        // AJAX call to get new data
        $.ajax({
            url: "{{ route('admin.dashboard.sales-data') }}",
            data: { range: range },
            success: function(response) {
                // Update chart with new data
                salesChart.data.labels = response.labels;
                salesChart.data.datasets[0].data = response.values;
                salesChart.update();
            }
        });
    });

    // Handle genre chart view changes
    $('.dropdown-item[data-view]').click(function(e) {
        e.preventDefault();
        var view = $(this).data('view');
        
        // AJAX call to get new data
        $.ajax({
            url: "{{ route('admin.dashboard.genres-data') }}",
            data: { view: view },
            success: function(response) {
                // Update chart with new data
                genresChart.data.labels = response.labels;
                genresChart.data.datasets[0].data = response.values;
                genresChart.data.datasets[0].backgroundColor = response.colors;
                genresChart.data.datasets[0].hoverBackgroundColor = response.hoverColors;
                genresChart.update();
                
                // Update the legend
                var legendHtml = '';
                for (var i = 0; i < response.labels.length; i++) {
                    legendHtml += '<span class="mr-2"><i class="fas fa-circle" style="color: ' + 
                                 response.colors[i] + '"></i> ' + response.labels[i] + '</span>';
                }
                $('.mt-4.text-center.small').html(legendHtml);
            }
        });
    });
</script>
@endsection