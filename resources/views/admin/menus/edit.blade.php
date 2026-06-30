@extends('admin.layouts.app')

@section('title', 'Edit Menu')
@section('page_title', 'Edit Menu')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Menus', 'url' => route('admin.menus.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Menu',
        'slot' => view('admin.menus._form', [
            'menu' => $menu,
            'action' => route('admin.menus.update', $menu),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
