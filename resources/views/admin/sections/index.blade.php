@extends('admin.layouts.app')

@section('title', 'Homepage Sections')
@section('page_title', 'Homepage Sections')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Homepage Sections', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Homepage Sections',
        'actions' => '<a href="' . route('admin.sections.create') . '" class="btn btn-primary">Create Section</a>',
        'slot' => view('admin.sections._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Section List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.sections._table', ['sections' => $sections])->render(),
    ])
@endsection
