@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users Management</h1>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-user-plus fa-sm text-white-50"></i> Add New User
            </a>
            <a href="{{ route('admin.users.export') }}" class="btn btn-sm btn-success shadow-sm ml-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Export Users
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Users</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.index') }}" method="GET" class="row">
                <div class="col-md-3 mb-2">
                    <label for="search">Search:</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Name, Email or Username" value="{{ request('search') }}">
                </div>
                <div class="col-md-2 mb-2">
                    <label for="role">Role:</label>
                    <select class="form-control" id="role" name="role">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="subscription">Subscription:</label>
                    <select class="form-control" id="subscription" name="subscription">
                        <option value="">All Plans</option>
                        @foreach($subscriptionPlans as $plan)
                            <option value="{{ $plan->id }}" {{ request('subscription') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <label for="sort">Sort By:</label>
                    <select class="form-control" id="sort" name="sort">
                        <option value="created_at-desc" {{ request('sort') == 'created_at-desc' ? 'selected' : '' }}>Newest First</option>
                        <option value="created_at-asc" {{ request('sort') == 'created_at-asc' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Name (Z-A)</option>
                        <option value="last_login-desc" {{ request('sort') == 'last_login-desc' ? 'selected' : '' }}>Last Login</option>
                    </select>
                </div>
                <div class="col-md-1 mb-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">All Users ({{ $users->total() }})</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Bulk Actions:</div>
                    <a class="dropdown-item" href="#" id="bulkActivate">Activate Selected</a>
                    <a class="dropdown-item" href="#" id="bulkDeactivate">Deactivate Selected</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#" id="bulkDelete">Delete Selected</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="selectAll">
                                    <label class="custom-control-label" for="selectAll"></label>
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Subscription</th>
                            <th>Downloads</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="{{ $user->status === 'suspended' ? 'table-danger' : ($user->status === 'inactive' ? 'table-warning' : '') }}">
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input user-select" id="select{{ $user->id }}" value="{{ $user->id }}">
                                    <label class="custom-control-label" for="select{{ $user->id }}"></label>
                                </div>
                            </td>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar mr-2">
                                        <img src="{{ $user->avatar_url ?? asset('images/default-avatar.png') }}" alt="Avatar" class="rounded-circle" width="40">
                                    </div>
                                    <div>
                                        <div>{{ $user->name }}</div>
                                        <small class="text-muted">{{ $user->username }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->subscription)
                                    <span class="badge badge-success">{{ $user->subscription->plan->name }}</span>
                                @else
                                    <span class="badge badge-secondary">Free</span>
                                @endif
                            </td>
                            <td>{{ $user->downloads_count }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge badge-success">Active</span>
                                @elseif($user->status === 'inactive')
                                    <span class="badge badge-warning">Inactive</span>
                                @elseif($user->status === 'suspended')
                                    <span class="badge badge-danger">Suspended</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger delete-user" data-id="{{ $user->id }}" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No users found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    </div>

    <!-- User Statistics Card -->
    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Users
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Active Users
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activeUsers }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Premium Subscribers
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $premiumUsers }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-crown fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                New Users (This Month)
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $newUsersThisMonth }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-6 col-lg-6">
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
    </div>
</div>

<!-- Delete User Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Are you sure you want to delete this user? This action cannot be undone.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Modal -->
<div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog" aria-labelledby="bulkActionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkActionModalLabel">Confirm Action</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="bulkActionMessage">Are you sure you want to perform this action?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form id="bulkActionForm" method="POST" action="{{ route('admin.users.bulk-action') }}">
                    @csrf
                    <input type="hidden" name="action" id="bulkActionType">
                    <input type="hidden" name="user_ids" id="selectedUserIds">
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // User Growth Chart
        var ctx = document.getElementById("userGrowthChart");
        var userGrowthData = @json($userGrowthData);
        
        var userGrowthChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: userGrowthData.labels,
                datasets: [{
                    label: "New Users",
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
                    data: userGrowthData.values,
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

        // Select All Checkbox
        $('#selectAll').change(function() {
            $('.user-select').prop('checked', $(this).prop('checked'));
        });

        // Delete User
        $('.delete-user').click(function() {
            var userId = $(this).data('id');
            $('#deleteForm').attr('action', '/admin/users/' + userId);
            $('#deleteModal').modal('show');
        });

        // Bulk Actions
        $('#bulkActivate').click(function() {
            setupBulkAction('activate', 'Are you sure you want to activate the selected users?');
        });

        $('#bulkDeactivate').click(function() {
            setupBulkAction('deactivate', 'Are you sure you want to deactivate the selected users?');
        });

        $('#bulkDelete').click(function() {
            setupBulkAction('delete', 'Are you sure you want to delete the selected users? This action cannot be undone.');
        });

        function setupBulkAction(action, message) {
            var selectedIds = [];
            $('.user-select:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                alert('Please select at least one user.');
                return;
            }

            $('#bulkActionType').val(action);
            $('#selectedUserIds').val(selectedIds.join(','));
            $('#bulkActionMessage').text(message);
            $('#bulkActionModal').modal('show');
        }
    });
</script>
@endsection