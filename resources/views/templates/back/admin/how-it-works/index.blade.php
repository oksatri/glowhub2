@extends('templates.back._parts.master')

@section('title', 'How It Works Management')
@section('page-title', 'How It Works Management')
@section('page-subtitle', 'Manage your process steps and workflow')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">How It Works Management</h1>
                <p class="mb-0 text-muted">Manage your process steps and workflow</p>
            </div>
            <a href="{{ route('admin.how-it-works.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Step
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Desktop Table View -->
        <div class="card shadow mb-4 d-none d-md-block">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">Step</th>
                                <th style="width: 100px;">Image</th>
                                <th style="width: 80px;">Icon</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th style="width: 100px;">Status</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($howItWorks as $step)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $step->step_number }}</span>
                                    </td>
                                    <td>
                                        @if ($step->image)
                                            <img src="{{ asset('storage/' . $step->image) }}" alt="{{ $step->title }}"
                                                class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="text-muted">
                                                <i class="fas fa-image fa-2x"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($step->icon)
                                            <i class="{{ $step->icon }} fa-2x text-primary"></i>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $step->title }}</strong>
                                    </td>
                                    <td>
                                        <div style="max-width: 300px;">
                                            {{ Str::limit(strip_tags($step->description), 100) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if ($step->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.how-it-works.show', $step) }}"
                                                class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.how-it-works.edit', $step) }}"
                                                class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.how-it-works.destroy', $step) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this step?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-list-ul fa-3x mb-3"></i>
                                            <p class="mb-0">No steps found. <a
                                                    href="{{ route('admin.how-it-works.create') }}">Create your first
                                                    step</a></p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="d-block d-md-none">
            @forelse ($howItWorks as $step)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                @if ($step->image)
                                    <img src="{{ asset('storage/' . $step->image) }}" alt="{{ $step->title }}"
                                        class="img-fluid rounded" style="width: 100%; height: 80px; object-fit: cover;">
                                @else
                                    <div class="text-center text-muted bg-light rounded d-flex align-items-center justify-content-center"
                                        style="height: 80px;">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-9">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <span class="badge bg-primary me-2">Step {{ $step->step_number }}</span>
                                        @if ($step->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </div>
                                    @if ($step->icon)
                                        <i class="{{ $step->icon }} fa-lg text-primary"></i>
                                    @endif
                                </div>
                                <h6 class="card-title mb-2">{{ $step->title }}</h6>
                                <p class="card-text text-muted small mb-3">
                                    {{ Str::limit(strip_tags($step->description), 80) }}
                                </p>
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('admin.how-it-works.show', $step) }}"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.how-it-works.edit', $step) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.how-it-works.destroy', $step) }}" method="POST"
                                        class="d-inline flex-fill" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-list-ul fa-3x text-muted mb-3"></i>
                        <h5>No Steps Found</h5>
                        <p class="text-muted mb-3">Start by creating your first process step</p>
                        <a href="{{ route('admin.how-it-works.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Step
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($howItWorks->hasPages())
            <div class="d-flex justify-content-center">
                {{ $howItWorks->links() }}
            </div>
        @endif
    </div>
@endsection
