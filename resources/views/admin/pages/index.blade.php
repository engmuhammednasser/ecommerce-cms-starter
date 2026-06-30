@extends('admin.layouts.app')

@section('title', 'Pages')
@section('page_title', 'Pages')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Pages', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Pages',
        'actions' => '<a href="' . route('admin.pages.create') . '" class="btn btn-primary">Create Page</a>',
        'slot' => view('admin.pages._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Page List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.pages._table', ['pages' => $pages])->render(),
    ])
@endsection
