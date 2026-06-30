@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('page_title', 'Create Category')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Categories', 'url' => route('admin.categories.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Category',
        'slot' => view('admin.categories._form', [
            'category' => $category,
            'parentOptions' => $parentOptions,
            'action' => route('admin.categories.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
