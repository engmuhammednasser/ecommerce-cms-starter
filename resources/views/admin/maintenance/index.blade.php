@extends('admin.layouts.app')

@section('title', 'Maintenance')
@section('page_title', 'Maintenance')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Maintenance', 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="row g-3">
        <div class="col-lg-7">
            @include('admin.components.card', [
                'title' => 'System Information',
                'bodyClass' => 'p-0',
                'slot' => view('admin.maintenance._system-info', ['systemInfo' => $systemInfo])->render(),
            ])
        </div>

        <div class="col-lg-5">
            @include('admin.components.card', [
                'title' => 'Safe Cache Actions',
                'slot' => view('admin.maintenance._cache-actions', ['clearActions' => $clearActions])->render(),
            ])
        </div>
    </div>
@endsection
