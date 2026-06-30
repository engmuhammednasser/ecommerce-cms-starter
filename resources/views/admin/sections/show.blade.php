@extends('admin.layouts.app')

@section('title', $section->title ?: $section->typeLabel())
@section('page_title', $section->title ?: $section->typeLabel())

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Homepage Sections', 'url' => route('admin.sections.index')],
        ['label' => $section->title ?: $section->typeLabel(), 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Section Details',
        'actions' => '<a href="' . route('admin.sections.edit', $section) . '" class="btn btn-primary">Edit Section</a>',
        'slot' => view('admin.sections._details', ['section' => $section])->render(),
    ])
@endsection
