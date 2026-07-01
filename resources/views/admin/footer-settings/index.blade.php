@extends('admin.layouts.app')

@section('title', 'Footer Settings')
@section('page_title', 'Footer Settings')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Appearance', 'url' => '#'],
        ['label' => 'Footer Settings', 'url' => '#'],
    ];
@endphp

@section('content')
    <form method="POST" action="{{ route('admin.footer-settings.update') }}">
        @csrf
        @method('PUT')

        @include('admin.components.card', [
            'title' => 'Footer Settings',
            'subtitle' => 'Control simple storefront footer text and visibility.',
            'slot' => view('admin.settings._group', ['items' => $items])->render(),
        ])

        <div class="settings-actions d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Footer Settings</button>
        </div>
    </form>
@endsection
