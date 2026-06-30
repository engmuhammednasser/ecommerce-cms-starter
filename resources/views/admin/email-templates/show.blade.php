@extends('admin.layouts.app')

@section('title', $emailTemplate->name)
@section('page_title', $emailTemplate->name)

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Email Templates', 'url' => route('admin.email-templates.index')],
        ['label' => $emailTemplate->name, 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => $emailTemplate->name,
        'subtitle' => 'Template key: ' . $emailTemplate->key,
        'slot' => view('admin.email-templates._details', ['template' => $emailTemplate])->render(),
    ])
@endsection
