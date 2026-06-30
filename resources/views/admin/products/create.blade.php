@extends('admin.layouts.app')

@section('title', 'Create Product')
@section('page_title', 'Create Product')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Product',
        'slot' => view('admin.products._form', [
            'product' => $product,
            'categoryOptions' => $categoryOptions,
            'imagePaths' => $imagePaths,
            'action' => route('admin.products.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
