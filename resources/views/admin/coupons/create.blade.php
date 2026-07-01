@extends('admin.layouts.app')

@section('title', 'Create Coupon')
@section('page_title', 'Create Coupon')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Coupons', 'url' => route('admin.coupons.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Coupon',
        'slot' => view('admin.coupons._form', [
            'coupon' => $coupon,
            'action' => route('admin.coupons.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
