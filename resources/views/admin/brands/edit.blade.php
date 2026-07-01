@extends('admin.layouts.app')

@section('title', 'Edit Brand')
@section('page_title', 'Edit Brand')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Brands', 'url' => route('admin.brands.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Brand',
        'slot' => view('admin.brands._form', [
            'brand' => $brand,
            'action' => route('admin.brands.update', $brand),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
