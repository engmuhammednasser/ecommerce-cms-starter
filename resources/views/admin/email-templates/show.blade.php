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
    <div class="mb-4">
        <a href="{{ route('admin.email-templates.edit', $emailTemplate) }}" class="btn btn-primary">
            <i class="fas fa-edit mr-1"></i> Edit Template
        </a>
    </div>

    @include('admin.components.card', [
        'title' => $emailTemplate->name,
        'subtitle' => 'Template key: ' . $emailTemplate->key,
        'slot' => view('admin.email-templates._details', ['template' => $emailTemplate])->render(),
    ])
@endsection
