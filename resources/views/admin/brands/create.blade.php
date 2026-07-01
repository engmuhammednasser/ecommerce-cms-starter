@extends('admin.layouts.app')

@section('title', 'Create Brand')
@section('page_title', 'Create Brand')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Brands', 'url' => route('admin.brands.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Brand',
        'slot' => view('admin.brands._form', [
            'brand' => $brand,
            'action' => route('admin.brands.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
