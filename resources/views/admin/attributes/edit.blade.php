@extends('admin.layouts.app')

@section('title', 'Edit Attribute')
@section('page_title', 'Edit Attribute')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Attributes', 'url' => route('admin.attributes.index')],
        ['label' => 'Edit', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Edit Attribute',
        'slot' => view('admin.attributes._form', [
            'attribute' => $attribute,
            'valuesText' => $valuesText,
            'action' => route('admin.attributes.update', $attribute),
            'method' => 'PUT',
        ])->render(),
    ])
@endsection
