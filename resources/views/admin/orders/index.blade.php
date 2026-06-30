@extends('admin.layouts.app')

@section('title', 'Orders')
@section('page_title', 'Orders')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Orders', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Orders',
        'slot' => view('admin.orders._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Order List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.orders._table', ['orders' => $orders])->render(),
    ])
@endsection
