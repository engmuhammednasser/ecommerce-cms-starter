@extends('admin.layouts.app')

@section('title', 'Edit Section')
@section('page_title', 'Edit Section')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Homepage Sections', 'url' => route('admin.sections.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Homepage Section',
        'slot' => view('admin.sections._form', [
            'section' => $section,
            'pages' => $pages,
            'action' => route('admin.sections.update', $section),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
