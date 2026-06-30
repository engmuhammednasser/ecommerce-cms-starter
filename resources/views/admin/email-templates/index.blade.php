@extends('admin.layouts.app')

@section('title', 'Email Templates')
@section('page_title', 'Email Templates')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Email Templates', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Email Templates',
        'subtitle' => 'Database-backed starter templates for order, account, and contact notifications.',
        'slot' => view('admin.email-templates._table', ['templates' => $templates])->render(),
    ])
@endsection
