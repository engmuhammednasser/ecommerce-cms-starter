@extends('admin.layouts.app')

@section('title', 'Create Section')
@section('page_title', 'Create Section')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Homepage Sections', 'url' => route('admin.sections.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Homepage Section',
        'slot' => view('admin.sections._form', [
            'section' => $section,
            'pages' => $pages,
            'action' => route('admin.sections.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
