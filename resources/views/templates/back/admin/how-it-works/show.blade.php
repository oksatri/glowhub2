@extends('templates.back._parts.master')

@section('title', 'Process Step Details')
@section('page-title', 'Process Step Details')
@section('page-subtitle', 'Step {{ $howItWork->step_number }}: {{ $howItWork->title }}')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">Process Step Details</h1>
                <p class="mb-0 text-muted">
                    <span class="badge bg-primary me-2">Step {{ $howItWork->step_number }}</span>
                    {{ $howItWork->title }}
                </p>
            </div>
            <div class="btn-group">
                <a href="{{ route('admin.how-it-works.edit', $howItWork) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Step
                </a>
                <a href="{{ route('admin.how-it-works.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Steps
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-list-ol me-2"></i>Step Information
                            </h6>
                            @if ($howItWork->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h4 class="text-primary mb-3">{{ $howItWork->title }}</h4>
                                <div class="text-muted mb-3">
                                    {{ $howItWork->description }}
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                @if ($howItWork->icon)
                                    <div class="mb-3">
                                        <i class="{{ $howItWork->icon }} fa-4x text-primary"></i>
                                        <div class="small text-muted mt-2">Icon: {{ $howItWork->icon }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if ($howItWork->image)
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-primary mb-3">Step Image</h6>
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $howItWork->image) }}"
                                            alt="{{ $howItWork->title }}" class="img-fluid rounded shadow"
                                            style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-eye me-2"></i>Frontend Preview
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            This is how this step would appear on your website
                        </div>

                        <!-- Simulated frontend display -->
                        <div class="border rounded p-4 bg-light">
                            <div class="text-center">
                                <div class="mb-3">
                                    <span class="badge bg-primary fs-6 mb-3">Step {{ $howItWork->step_number }}</span>
                                </div>

                                @if ($howItWork->image)
                                    <img src="{{ asset('storage/' . $howItWork->image) }}" alt="{{ $howItWork->title }}"
                                        class="img-fluid rounded mb-3"
                                        style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                @elseif ($howItWork->icon)
                                    <div class="mb-3">
                                        <i class="{{ $howItWork->icon }} fa-4x text-primary"></i>
                                    </div>
                                @endif

                                <h5 class="text-dark mb-3">{{ $howItWork->title }}</h5>
                                <p class="text-muted mb-0">{{ $howItWork->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-cog me-2"></i>Step Details
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong class="text-primary">Step Number:</strong>
                            <div class="text-muted">{{ $howItWork->step_number }}</div>
                        </div>

                        <div class="mb-3">
                            <strong class="text-primary">Status:</strong>
                            <div>
                                @if ($howItWork->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                    <div class="small text-muted">Visible on website</div>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                    <div class="small text-muted">Hidden from website</div>
                                @endif
                            </div>
                        </div>

                        @if ($howItWork->icon)
                            <div class="mb-3">
                                <strong class="text-primary">Icon:</strong>
                                <div class="text-muted">{{ $howItWork->icon }}</div>
                            </div>
                        @endif

                        @if ($howItWork->image)
                            <div class="mb-3">
                                <strong class="text-primary">Image:</strong>
                                <div class="text-muted small">{{ basename($howItWork->image) }}</div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <strong class="text-primary">Created:</strong>
                            <div class="text-muted small">{{ $howItWork->created_at->format('M d, Y \a\t H:i') }}</div>
                        </div>

                        <div class="mb-3">
                            <strong class="text-primary">Last Updated:</strong>
                            <div class="text-muted small">{{ $howItWork->updated_at->format('M d, Y \a\t H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-bolt me-2"></i>Actions
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.how-it-works.edit', $howItWork) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>Edit This Step
                            </a>

                            <a href="{{ route('admin.how-it-works.create') }}" class="btn btn-success">
                                <i class="fas fa-plus me-2"></i>Add New Step
                            </a>

                            <hr>

                            <form action="{{ route('admin.how-it-works.destroy', $howItWork) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this step? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-2"></i>Delete Step
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
