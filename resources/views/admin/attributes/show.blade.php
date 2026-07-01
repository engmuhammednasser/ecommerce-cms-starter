@extends('admin.layouts.app')

@section('title', $attribute->name)
@section('page_title', $attribute->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Attributes', 'url' => route('admin.attributes.index')],
        ['label' => $attribute->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Attribute Details',
        'actions' => '<a href="' . route('admin.attributes.edit', $attribute) . '" class="btn btn-primary">Edit Attribute</a>',
        'slot' => view('admin.attributes._details', ['attribute' => $attribute])->render(),
    ])
@endsection
