@extends('admin.layouts.app')

@section('title', 'Edit Admin User')
@section('page_title', 'Edit Admin User')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admin Users', 'url' => route('admin.users.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Admin User',
        'slot' => view('admin.users._form', [
            'user' => $user,
            'roles' => $roles,
            'selectedRoles' => $selectedRoles,
            'action' => route('admin.users.update', $user),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
