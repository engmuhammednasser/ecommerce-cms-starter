@extends('admin.layouts.app')

@section('title', 'Header Settings')
@section('page_title', 'Header Settings')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Appearance', 'url' => '#'],
        ['label' => 'Header Settings', 'url' => '#'],
    ];
@endphp

@section('content')
    <form method="POST" action="{{ route('admin.header-settings.update') }}">
        @csrf
        @method('PUT')

        @include('admin.components.card', [
            'title' => 'Header Settings',
            'subtitle' => 'Control simple storefront header behavior and labels.',
            'slot' => view('admin.settings._group', ['items' => $items])->render(),
        ])

        <div class="settings-actions d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Header Settings</button>
        </div>
    </form>
@endsection
