@extends('back._parts.master')
@section('page-title', 'Edit Testimonial')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Edit Testimonial</h1>
            <p class="text-muted small mb-0">Update testimonial entry.</p>
        </div>
        <a href="{{ url('testimonials') }}" class="btn px-3 py-2"
            style="background:white; border:1px solid #E5E7EB; color:#374151;">Back to list</a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body px-4 py-4">
            <form action="{{ url('testimonials/' . $t->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('back.testimonials._form', ['testimonial' => $t, 'submitLabel' => 'Save Changes'])
            </form>
        </div>
    </div>
@endsection
