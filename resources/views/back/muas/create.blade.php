@extends('back._parts.master')
@section('page-title', 'Create MUA')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Create MUA</h1>
            <p class="text-muted small mb-0">Add new Makeup Artist profile.</p>
        </div>
        @php $base = (Auth::check() && Auth::user()->role === 'admin') ? 'admin/muas' : 'muas'; @endphp
        <a href="{{ url($base) }}" class="btn px-3 py-2" style="background:white; border:1px solid #E5E7EB; color:#374151;">
            <i class="fas fa-arrow-left me-2"></i>Back to list
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @php $base = (Auth::check() && Auth::user()->role === 'admin') ? 'admin/muas' : 'muas'; @endphp
            <form method="POST" action="{{ url($base) }}" enctype="multipart/form-data">
                @csrf
                @include('back.muas._form')

                <div class="mt-4 d-flex align-items-center gap-2">
                    <button class="btn px-4 py-2 rounded-pill text-white"
                        style="background: linear-gradient(135deg,#667EEA 0%,#764BA2 100%); border:none;">Create
                        MUA</button>
                    <a href="{{ url($base) }}" class="btn" style="background:transparent; color:#6B7280;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

@endsection
