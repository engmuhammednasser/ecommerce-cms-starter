@extends('admin.layouts.app')

@section('title', 'Create Page')
@section('page_title', 'Create Page')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Pages', 'url' => route('admin.pages.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Page',
        'slot' => view('admin.pages._form', [
            'page' => $page,
            'action' => route('admin.pages.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
