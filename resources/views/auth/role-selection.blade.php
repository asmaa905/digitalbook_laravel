@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">Select Your Role</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('role.process') }}">
                        @csrf
                        <div class="row text-center">
                            <!-- Employer Card -->
                            <div class="col-md-6">
                                <input type="radio" id="employer" name="role" value="employer" class="d-none">
                                <label for="employer" class="card p-4 border role-card">
                                    <div class="mb-3">
                                        <i class="fas fa-briefcase fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="fw-bold">Employer</h5>
                                    <p>Post jobs and hire top talent.</p>
                                </label>
                            </div>

                            <!-- Candidate Card -->
                            <div class="col-md-6">
                                <input type="radio" id="candidate" name="role" value="candidate" class="d-none">
                                <label for="candidate" class="card p-4 border role-card">
                                    <div class="mb-3">
                                        <i class="fas fa-user fa-3x text-success"></i>
                                    </div>
                                    <h5 class="fw-bold">Candidate</h5>
                                    <p>Search for jobs and apply easily.</p>
                                </label>
                            </div>
                        </div>

                        @error('role') 
                            <div class="text-danger text-center mt-3">{{ $message }}</div> 
                        @enderror

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script to Handle Selection -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleCards = document.querySelectorAll('.role-card');
        const roleInputs = document.querySelectorAll('input[name="role"]');

        roleCards.forEach((card, index) => {
            card.addEventListener('click', function() {
                roleCards.forEach(c => c.classList.remove('border-primary', 'bg-light'));
                this.classList.add('border-primary', 'bg-light');
                roleInputs[index].checked = true;
            });
        });
    });
</script>

@endsection