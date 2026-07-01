@extends('admin.layouts.app')

@section('title', 'Admin User Details')
@section('page_title', 'Admin User Details')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Admin Users', 'url' => route('admin.users.index')],
        ['label' => $user->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => $user->name,
        'actions' => '<a href="' . route('admin.users.edit', $user) . '" class="btn btn-primary">Edit User</a>',
        'slot' => view('admin.users._details', ['user' => $user])->render(),
    ])
@endsection
