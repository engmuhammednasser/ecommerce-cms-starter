@extends('admin.layouts.app')

@section('title', 'Brands')
@section('page_title', 'Brands')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Brands', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Brands',
        'actions' => '<a href="' . route('admin.brands.create') . '" class="btn btn-primary">Create Brand</a>',
        'slot' => view('admin.brands._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Brand List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.brands._table', ['brands' => $brands])->render(),
    ])
@endsection
