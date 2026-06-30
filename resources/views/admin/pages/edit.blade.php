@extends('admin.layouts.app')

@section('title', 'Edit Page')
@section('page_title', 'Edit Page')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Pages', 'url' => route('admin.pages.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Page',
        'slot' => view('admin.pages._form', [
            'page' => $page,
            'action' => route('admin.pages.update', $page),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
