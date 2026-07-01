@extends('admin.layouts.app')

@section('title', 'Create Attribute')
@section('page_title', 'Create Attribute')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Attributes', 'url' => route('admin.attributes.index')],
        ['label' => 'Create', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Create Attribute',
        'slot' => view('admin.attributes._form', [
            'attribute' => $attribute,
            'valuesText' => $valuesText,
            'action' => route('admin.attributes.store'),
            'method' => 'POST',
        ])->render(),
    ])
@endsection
