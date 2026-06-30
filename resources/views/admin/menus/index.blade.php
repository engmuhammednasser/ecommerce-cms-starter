@extends('admin.layouts.app')

@section('title', 'Menus')
@section('page_title', 'Menus')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Menus', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Menus',
        'actions' => '<a href="' . route('admin.menus.create') . '" class="btn btn-primary">Create Menu</a>',
        'bodyClass' => 'p-0',
        'slot' => view('admin.menus._table', ['menus' => $menus])->render(),
    ])
@endsection
