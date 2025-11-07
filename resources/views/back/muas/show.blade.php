@extends('back._parts.master')
@section('page-title', $mua->name)
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">{{ $mua->name }}</h1>
            <p class="text-muted small mb-0">MUA profile & services</p>
        </div>
        <a href="{{ url('muas/' . $mua->id . '/edit') }}" class="btn btn-primary">Edit</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card p-3">
                @if ($mua->image)
                    <img src="{{ asset('storage/' . $mua->image) }}" alt="" class="img-fluid rounded mb-3">
                @endif
                <h4>{{ $mua->name }}</h4>
                <p class="text-muted">{{ $mua->specialty }}</p>
                <p class="mb-1">
                    @if ($mua->district)
                        {{ App\Models\RegDistrict::find($mua->district)->name ?? $mua->district }},
                    @endif
                    @if ($mua->city)
                        {{ App\Models\RegRegency::find($mua->city)->name ?? $mua->city }},
                    @endif
                    @if ($mua->province)
                        {{ App\Models\RegProvince::find($mua->province)->name ?? $mua->province }}
                    @endif
                </p>
                @if ($mua->description)
                    <p>{{ $mua->description }}</p>
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card p-3">
                <h5>Services</h5>
                @if ($mua->services->count())
                    <ul class="list-group">
                        @foreach ($mua->services as $s)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="font-weight:600">{{ $s->nama_service }}</div>
                                    <div class="small text-muted">Rp {{ number_format($s->harga) }}</div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No services yet.</p>
                @endif
            </div>
        </div>
    </div>

@endsection
