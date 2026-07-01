@extends('admin.layouts.app')

@section('title', 'Admin Users')
@section('page_title', 'Admin Users')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admin Users', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Admin Users',
        'actions' => '<a href="' . route('admin.users.create') . '" class="btn btn-primary">Create Admin User</a>',
        'slot' => view('admin.users._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'User List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.users._table', ['users' => $users])->render(),
    ])
@endsection
