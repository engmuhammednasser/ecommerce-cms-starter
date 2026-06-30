@extends('admin.layouts.app')

@section('title', 'Products')
@section('page_title', 'Products')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Products',
        'actions' => '<a href="' . route('admin.products.create') . '" class="btn btn-primary">Create Product</a>',
        'slot' => view('admin.products._filters', ['categoryOptions' => $categoryOptions])->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Product List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.products._table', ['products' => $products])->render(),
    ])
@endsection
