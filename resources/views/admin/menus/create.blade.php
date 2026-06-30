@extends('admin.layouts.app')

@section('title', 'Create Menu')
@section('page_title', 'Create Menu')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Menus', 'url' => route('admin.menus.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Menu',
        'slot' => view('admin.menus._form', [
            'menu' => $menu,
            'action' => route('admin.menus.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
