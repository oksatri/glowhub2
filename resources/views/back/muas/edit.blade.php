@extends('back._parts.master')
@section('page-title', 'Edit MUA')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Edit MUA</h1>
            <p class="text-muted small mb-0">Update MUA profile and manage services/portfolio.</p>
        </div>
        <a href="{{ url('muas') }}" class="btn px-3 py-2" style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form method="POST" action="{{ url('muas/' . $mua->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('back.muas._form')

                <div class="mt-3 d-flex justify-content-between">
                    <div>
                        <!-- Quick add service -->
                        <form method="POST" action="{{ url('muas/' . $mua->id . '/services') }}" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="nama_service" class="form-control" placeholder="Service name"
                                required>
                            <input type="number" name="harga" class="form-control" placeholder="Price">
                            <button class="btn btn-outline-primary">Add Service</button>
                        </form>
                    </div>

                    <div>
                        <button class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>

            <hr class="my-4">

            <h5>Services</h5>
            @if ($mua->services->count())
                <ul class="list-group mb-3">
                    @foreach ($mua->services as $s)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <div style="font-weight:600">{{ $s->service_name }}</div>
                                <div class="small text-muted">Rp {{ number_format($s->price) }}</div>
                            </div>
                            <div class="btn-group">
                                <form action="{{ url('muas/' . $mua->id . '/services/' . $s->id) }}" method="POST"
                                    onsubmit="return confirm('Remove service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No services yet.</p>
            @endif

            <h5 class="mt-4">Portfolios</h5>
            <!-- quick upload portfolio -->
            @if ($mua->services->count())
                <form method="POST" action="{{ url('muas/' . $mua->id . '/portfolios') }}" enctype="multipart/form-data"
                    class="mb-3 d-flex gap-2">
                    @csrf
                    <select name="mua_service_id" class="form-control" required>
                        <option value="">-- Select service --</option>
                        @foreach ($mua->services as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->service_name ?? ($s->nama_service ?? 'Service #' . $s->id) }}</option>
                        @endforeach
                    </select>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                    <input type="text" name="description" class="form-control" placeholder="Description (optional)">
                    <button class="btn btn-outline-primary">Upload</button>
                </form>
            @else
                <div class="alert alert-warning">You need to add at least one service before uploading portfolios. Use the
                    quick "Add Service" box above.</div>
            @endif

            @if ($mua->portfolios->count())
                <div class="row g-2">
                    @foreach ($mua->portfolios as $p)
                        <div class="col-3">
                            <div class="card p-2">
                                @if ($p->image)
                                    <img src="{{ asset('storage/' . $p->image) }}" class="img-fluid">
                                @endif
                                <div class="small text-muted mt-2">{{ $p->description }}</div>
                                <form action="{{ url('muas/' . $mua->id . '/portfolios/' . $p->id) }}" method="POST"
                                    onsubmit="return confirm('Remove?');" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger w-100">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection
