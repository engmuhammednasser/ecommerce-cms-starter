@extends('admin.layouts.app')

@section('title', $coupon->code)
@section('page_title', $coupon->code)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Coupons', 'url' => route('admin.coupons.index')],
        ['label' => $coupon->code, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => $coupon->code,
        'actions' => '<a href="' . route('admin.coupons.edit', $coupon) . '" class="btn btn-primary">Edit Coupon</a>',
        'slot' => view('admin.coupons._details', ['coupon' => $coupon])->render(),
    ])
@endsection
