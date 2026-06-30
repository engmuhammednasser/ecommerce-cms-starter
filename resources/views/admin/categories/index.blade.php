@extends('admin.layouts.app')

@section('title', 'Categories')
@section('page_title', 'Categories')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Categories', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Categories',
        'actions' => '<a href="' . route('admin.categories.create') . '" class="btn btn-primary">Create Category</a>',
        'slot' => view('admin.categories._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Category List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.categories._table', ['categories' => $categories])->render(),
    ])
@endsection
