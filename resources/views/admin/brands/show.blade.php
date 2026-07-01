@extends('admin.layouts.app')

@section('title', $brand->name)
@section('page_title', $brand->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Brands', 'url' => route('admin.brands.index')],
        ['label' => $brand->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Brand Details',
        'actions' => '<a href="' . route('admin.brands.edit', $brand) . '" class="btn btn-primary">Edit Brand</a>',
        'slot' => view('admin.brands._details', ['brand' => $brand])->render(),
    ])
@endsection
