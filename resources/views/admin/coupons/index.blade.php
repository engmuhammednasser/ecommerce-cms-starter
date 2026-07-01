@extends('admin.layouts.app')

@section('title', 'Coupons')
@section('page_title', 'Coupons')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Coupons', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Coupons',
        'actions' => '<a href="' . route('admin.coupons.create') . '" class="btn btn-primary">Create Coupon</a>',
        'slot' => view('admin.coupons._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Coupon List',
        'bodyClass' => 'p-0',
        'slot' => view('admin.coupons._table', ['coupons' => $coupons])->render(),
    ])
@endsection
