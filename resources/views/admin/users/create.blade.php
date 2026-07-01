@extends('admin.layouts.app')

@section('title', 'Create Admin User')
@section('page_title', 'Create Admin User')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admin Users', 'url' => route('admin.users.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Admin User',
        'slot' => view('admin.users._form', [
            'user' => $user,
            'roles' => $roles,
            'selectedRoles' => $selectedRoles,
            'action' => route('admin.users.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
