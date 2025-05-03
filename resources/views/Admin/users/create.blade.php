@extends('layouts.admin')

@section('admin-title', 'Create New User')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add New User</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Publisher" {{ old('role') == 'Publisher' ? 'selected' : '' }}>Publisher</option>
                            <option value="Reader" {{ old('role') == 'Reader' ? 'selected' : '' }}>Reader</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <small class="text-muted">Max 2MB, JPG/PNG/GIF</small>
            </div>

            <!-- Publisher Fields (shown only when role is Publisher) -->
            <div id="publisher-fields" style="display: none;">
                <h5 class="mb-3">Publisher Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="job_title" class="form-label">Job Title</label>
                            <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="publishing_house_id" class="form-label">Publishing House</label>
                            <select class="form-select" id="publishing_house_id" name="publishing_house_id">
                                <option value="">Select Publishing House</option>
                                @foreach($publishingHouses as $house)
                                    <option value="{{ $house->id }}" {{ old('publishing_house_id') == $house->id ? 'selected' : '' }}>
                                        {{ $house->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="identity_document" class="form-label">Identity Document</label>
                    <input type="file" class="form-control" id="identity_document" name="identity_document">
                    <small class="text-muted">PDF/JPG/PNG, Max 2MB</small>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-orange">Create User</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
@section('admin-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const publisherFields = document.getElementById('publisher-fields');

        function togglePublisherFields() {
            if (roleSelect.value === 'Publisher') {
                publisherFields.style.display = 'block';
                // Make publisher fields required
                document.getElementById('job_title').required = true;
                document.getElementById('publishing_house_id').required = true;
                document.getElementById('identity_document').required = true;
            } else {
                publisherFields.style.display = 'none';
                // Remove required from publisher fields
                document.getElementById('job_title').required = false;
                document.getElementById('publishing_house_id').required = false;
                document.getElementById('identity_document').required = false;
            }
        }

        // Initial check
        togglePublisherFields();

        // Add event listener
        roleSelect.addEventListener('change', togglePublisherFields);
    });
</script>
@endsection
