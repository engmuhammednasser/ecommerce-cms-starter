@extends('admin.layouts.app')

@section('title', $category->name)
@section('page_title', $category->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Categories', 'url' => route('admin.categories.index')],
        ['label' => $category->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Category Details',
        'actions' => '<a href="' . route('admin.categories.edit', $category) . '" class="btn btn-primary">Edit Category</a>',
        'slot' => view('admin.categories._details', ['category' => $category])->render(),
    ])
@endsection
