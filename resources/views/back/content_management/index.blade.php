@extends('back._parts.master')
@section('page-title', 'Content Management')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Content Management</h1>
            <p class="text-muted small mb-0">Elegant view to browse, filter and manage site content.</p>
        </div>
        <a href="{{ url('content-management/create') }}" class="btn btn-primary fw-semibold">
            <!-- simple plus SVG to avoid dependency on icon fonts -->
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus-lg me-2"
                viewBox="0 0 16 16">
                <path
                    d="M8 1a.5.5 0 0 1 .5.5v6.5H15a.5.5 0 0 1 0 1H8.5V15a.5.5 0 0 1-1 0V9.5H1a.5.5 0 0 1 0-1h6.5V1.5A.5.5 0 0 1 8 1z" />
            </svg>
            Create Content
        </a>
    </div>

    <form method="GET" action="{{ url('content-management') }}" class="card card-body mb-4 p-3">
        <div class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11 6a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                            <path d="M12.344 11.344 15 14l-1.5 1.5-2.656-2.656A6.5 6.5 0 1 0 12.344 11.344z" />
                        </svg>
                    </span>
                    <input type="text" name="title" class="form-control border-start-0"
                        placeholder="Search by title..." value="{{ request('title') }}">
                </div>
            </div>

            <div class="col-md-2">
                <select name="section_type" class="form-control form-select">
                    <option value="">All Types</option>
                    <option value="article" {{ request('section_type') == 'article' ? 'selected' : '' }}>Article</option>
                    <option value="video" {{ request('section_type') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="status" class="form-control form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="col-md-3 d-flex">
                <button type="submit" class="btn btn-outline-primary me-2 flex-grow-1">Filter</button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col text-muted small">
                Showing results for:
                <strong>{{ request('title') ?: 'any title' }}</strong>,
                type <strong>{{ request('section_type') ?: 'all' }}</strong>,
                status <strong>{{ request('status') ?: 'all' }}</strong>
            </div>
        </div>
    </form>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Created</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr>
                                <td>
                                    <strong>{{ $content->title }}</strong>
                                </td>
                                <td>
                                    {{ $content->section_type }}
                                </td>
                                <td>
                                    <span class="text-warning">{{ $content->status }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-primary rounded-circle">{{ $content->order ?? 0 }}</span>
                                </td>
                                <td>
                                    <span
                                        class="text-muted">{{ $content->created_at ? $content->created_at->format('Y-m-d') : '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ url('content-management/' . $content->id . '/edit') }}"
                                        class="btn btn-sm btn-outline-primary me-1">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ url('content-management/' . $content->id) }}" method="POST"
                                        style="display:inline-block;" onsubmit="return confirm('Delete this content?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger me-1">
                                            <i class="bi bi-trash"></i> Delete?
                                        </button>
                                    </form>
                                    @if ($content->status == 'publish')
                                        <form action="{{ url('content-management/' . $content->id . '/unpublish') }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-success">
                                                <i class="bi bi-upload"></i> Unpublish?
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ url('content-management/' . $content->id . '/publish') }}"
                                            method="POST" style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-sm btn-warning">
                                                <i class="bi bi-eye-slash"></i> Publish?
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">No contents found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        {{ $contents->links() }}
    </div>

@endsection
