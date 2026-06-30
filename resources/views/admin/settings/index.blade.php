@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page_title', 'Settings')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Settings', 'url' => '#'],
    ];
@endphp

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        @forelse ($settings as $group => $items)
            <div id="{{ $group }}-settings">
                @include('admin.components.card', [
                    'title' => ucfirst($group) . ' Settings',
                    'slot' => view('admin.settings._group', ['items' => $items])->render(),
                ])
            </div>
        @empty
            @include('admin.components.empty-state', [
                'title' => 'No settings found',
                'message' => 'Run the settings seeder to create editable store defaults.',
            ])
        @endforelse

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
@endsection
