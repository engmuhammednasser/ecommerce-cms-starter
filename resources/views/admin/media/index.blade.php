@extends('admin.layouts.app')

@section('title', 'Media Library')
@section('page_title', 'Media Library')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Media Library', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Upload Media',
        'subtitle' => 'Allowed files: JPG, PNG, WebP, GIF, SVG, and PDF up to 10 MB.',
        'slot' => view('admin.media._upload-form')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Media Files',
        'bodyClass' => 'p-0',
        'slot' => view('admin.media._list', ['mediaItems' => $mediaItems])->render(),
    ])
@endsection
