@extends('admin.layouts.app')

@section('title', 'Edit Coupon')
@section('page_title', 'Edit Coupon')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Coupons', 'url' => route('admin.coupons.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Coupon',
        'slot' => view('admin.coupons._form', [
            'coupon' => $coupon,
            'action' => route('admin.coupons.update', $coupon),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
