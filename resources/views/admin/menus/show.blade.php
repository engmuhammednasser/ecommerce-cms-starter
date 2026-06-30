@extends('admin.layouts.app')

@section('title', $menu->name)
@section('page_title', $menu->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Menus', 'url' => route('admin.menus.index')],
        ['label' => $menu->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Menu Details',
        'actions' => '<a href="' . route('admin.menus.edit', $menu) . '" class="btn btn-primary">Edit Menu</a>',
        'slot' => view('admin.menus._details', ['menu' => $menu])->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Add Menu Item',
        'slot' => view('admin.menus._item-form', [
            'menu' => $menu,
            'parentItems' => $parentItems,
        ])->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Menu Items',
        'bodyClass' => 'p-0',
        'slot' => view('admin.menus._items-table', ['menu' => $menu])->render(),
    ])
@endsection
