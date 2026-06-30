@extends('admin.layouts.app')

@section('title', $page->title)
@section('page_title', $page->title)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Pages', 'url' => route('admin.pages.index')],
        ['label' => $page->title, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Page Details',
        'actions' => '<a href="' . route('admin.pages.edit', $page) . '" class="btn btn-primary">Edit Page</a>',
        'slot' => view('admin.pages._details', ['page' => $page])->render(),
    ])
@endsection
