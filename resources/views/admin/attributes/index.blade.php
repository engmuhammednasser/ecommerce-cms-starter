@extends('admin.layouts.app')

@section('title', 'Attributes')
@section('page_title', 'Attributes')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Attributes', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Attributes',
        'actions' => '<a href="' . route('admin.attributes.create') . '" class="btn btn-primary">Create Attribute</a>',
        'slot' => view('admin.attributes._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Attribute List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.attributes._table', ['attributes' => $attributes])->render(),
    ])
@endsection
