@extends('back._parts.master')
@section('page-title', 'Dashboard')
@section('content')
    @php
        $role = auth()->check() ? auth()->user()->role : 'member';
    @endphp

    @if ($role === 'admin')
        @includeIf('back.dashboard.admin')
    @elseif ($role === 'mua')
        @includeIf('back.dashboard.mua')
    @else
        @includeIf('back.dashboard.member')
    @endif

@endsection
