@extends('back._parts.master')
@section('page-title', 'Create User')
@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1" style="color: #2D3748; font-weight:600;">Create User</h1>
            <p class="text-muted small mb-0">Add a new user with essential info only.</p>
        </div>
        <a href="{{ url('users') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;"><i class="fas fa-arrow-left me-2"></i>Back to
            list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form action="{{ url('users') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @include('back.users._form')

                <div class="mt-3 text-end">
                    <button class="btn px-4 py-2 rounded-pill text-white"
                        style="background: linear-gradient(135deg,#6D28D9,#2563EB);">Create User</button>
                </div>
            </form>
        </div>
    </div>

@endsection
