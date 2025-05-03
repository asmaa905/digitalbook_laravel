@props(['plan' => null])

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $plan ? 'Edit Plan' : 'Create New Plan' }}</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $plan ? route('admin.plans.update', $plan) : route('admin.plans.store') }}">
            @csrf
            @if($plan) @method('PUT') @endif

            <div class="mb-3">
                <label for="name" class="form-label">Plan Name</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="{{ old('name', $plan?->name) }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price (USD)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" 
                       value="{{ old('price', $plan?->price) }}" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="features" class="form-label">Features (One per line)</label>
                <textarea class="form-control" id="features" name="features" rows="5">
                    {{ old('features', $plan ? (is_array($plan->features) ? implode("\n", $plan->features) : $plan->features) : '') }}
                </textarea>
                <small class="text-muted">Enter each feature on a new line</small>
                @error('features')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="plan_duration" class="form-label">Plan Duration</label>
                <input type="number" class="form-control" id="plan_duration" name="plan_duration" 
                       value="{{ old('plan_duration', $plan?->plan_duration) }}">
                <small class="text-muted">Leave empty for free plan</small>
                @error('plan_duration')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="book_limit" class="form-label">Book Limit</label>
                <input type="number" class="form-control" id="book_limit" name="book_limit" 
                       value="{{ old('book_limit', $plan?->book_limit) }}">
                <small class="text-muted">Leave empty for unlimited books</small>
                @error('book_limit')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="instant_download" name="instant_download" 
                           value="1" {{ old('instant_download', $plan?->instant_download) ? 'checked' : '' }}>
                    <label class="form-check-label" for="instant_download">
                        Instant Download
                    </label>
                </div>
                @error('instant_download')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            {{--<div class="mb-3">
                <label for="free_trial_days" class="form-label">Free Trial Days</label>
                <input type="number" class="form-control" id="free_trial_days" name="free_trial_days" 
                       value="{{ old('free_trial_days', $plan?->free_trial_days ?? 0) }}" min="0">
                @error('free_trial_days')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>--}}

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                           value="1" {{ old('is_featured', $plan?->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                        Featured Plan
                    </label>
                </div>
                @error('is_featured')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-orange">
                    {{ $plan ? 'Update Plan' : 'Create Plan' }}
                </button>
            </div>
        </form>
    </div>
</div>
