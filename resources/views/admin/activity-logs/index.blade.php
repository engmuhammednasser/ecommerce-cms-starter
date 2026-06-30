@extends('admin.layouts.app')

@section('title', 'Activity Logs')
@section('page_title', 'Activity Logs')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Activity Logs', 'url' => '#'],
    ];
@endphp

@section('content')
    @include('admin.components.card', [
        'title' => 'Activity Logs',
        'slot' => view('admin.activity-logs._filters')->render(),
    ])

    @include('admin.components.card', [
        'title' => 'Recent Activity',
        'bodyClass' => 'p-0',
        'slot' => view('admin.activity-logs._table', ['activityLogs' => $activityLogs])->render(),
    ])
@endsection
