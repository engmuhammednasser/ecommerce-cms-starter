@extends('admin.layouts.app')

@section('title', $product->name)
@section('page_title', $product->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => $product->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Product Details',
        'actions' => '<a href="' . route('admin.products.edit', $product) . '" class="btn btn-primary">Edit Product</a>',
        'slot' => view('admin.products._details', ['product' => $product])->render(),
    ])
@endsection
