@extends('admin.layouts.app')

@section('title', 'Edit Variant — ' . $product->name)
@section('page_title', 'Edit Variant')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Products', 'url' => route('admin.products.index')],
        ['label' => $product->name, 'url' => route('admin.products.edit', $product)],
        ['label' => 'Edit Variant', 'url' => '#'],
    ];
@endphp

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Variant — {{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.variants.update', [$product, $variant]) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.product-variants._form', ['selectedValueIds' => $selectedValueIds])
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Variant</button>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
