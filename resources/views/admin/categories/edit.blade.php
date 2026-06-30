@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page_title', 'Edit Category')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Categories', 'url' => route('admin.categories.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Category',
        'slot' => view('admin.categories._form', [
            'category' => $category,
            'parentOptions' => $parentOptions,
            'action' => route('admin.categories.update', $category),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
