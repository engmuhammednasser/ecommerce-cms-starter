@extends('admin.layouts.app')

@section('title', 'Theme Settings')
@section('page_title', 'Theme Settings')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Appearance', 'url' => '#'],
        ['label' => 'Theme Settings', 'url' => '#'],
    ];

    $primaryColor = $items->firstWhere('key', 'primary_color')?->value ?: '#0d6efd';
    $secondaryColor = $items->firstWhere('key', 'secondary_color')?->value ?: '#6c757d';
@endphp

@section('content')
    <form method="POST" action="{{ route('admin.theme-settings.update') }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                @include('admin.components.card', [
                    'title' => 'Theme Colors',
                    'subtitle' => 'Adjust the primary and secondary colors used by the storefront theme.',
                    'slot' => view('admin.settings._group', ['items' => $items])->render(),
                ])
            </div>

            <div class="col-lg-4">
                @include('admin.components.card', [
                    'title' => 'Preview',
                    'subtitle' => 'A quick sample of the selected color palette.',
                    'slot' => view('admin.theme-settings._preview', [
                        'primaryColor' => $primaryColor,
                        'secondaryColor' => $secondaryColor,
                    ])->render(),
                ])
            </div>
        </div>

        <div class="settings-actions d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Theme Settings</button>
        </div>
    </form>
@endsection
