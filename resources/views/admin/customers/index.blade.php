@extends('admin.layouts.app')

@section('title', 'Customers')
@section('page_title', 'Customers')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Customers', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Customers',
        'slot' => view('admin.customers._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Customer List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.customers._table', ['customers' => $customers])->render(),
    ])
@endsection
