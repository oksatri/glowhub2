@extends('back._parts.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Bookings</h4>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>MUA</th>
                                    <th>Service</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $b)
                                    <tr>
                                        <td>{{ $b->id }}</td>
                                        <td>{{ optional($b->mua)->name ?? 'N/A' }}</td>
                                        <td>{{ optional($b->service)->service_name ?? '-' }}</td>
                                        <td>{{ $b->customer_name ?? optional($b->customer)->name }}</td>
                                        <td>{{ $b->selected_date->format('Y-m-d') }}</td>
                                        <td>{{ $b->selected_time }}</td>
                                        <td><span class="badge bg-info text-white">{{ $b->status }}</span></td>
                                        <td>
                                            <form action="{{ route('admin.bookings.update', $b->id) }}" method="POST"
                                                style="display:inline-block">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-select d-inline-block"
                                                    style="width:140px;">
                                                    <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="confirmed" {{ $b->status == 'confirmed' ? 'selected' : '' }}>
                                                        Confirm</option>
                                                    <option value="rejected" {{ $b->status == 'rejected' ? 'selected' : '' }}>
                                                        Reject</option>
                                                    <option value="completed" {{ $b->status == 'completed' ? 'selected' : '' }}>
                                                        Completed</option>
                                                </select>
                                                <button class="btn btn-sm btn-primary">Save</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
