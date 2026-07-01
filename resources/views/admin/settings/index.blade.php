@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page_title', 'Settings')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Settings', 'url' => '#'],
    ];

    $groupMeta = [
        'general' => [
            'label' => 'Store Identity',
            'description' => 'Control the store name, logo, and favicon used across the admin and storefront.',
        ],
        'admin' => [
            'label' => 'Admin Login',
            'description' => 'Customize the admin login page content and image.',
        ],
        'contact' => [
            'label' => 'Contact Info',
            'description' => 'Manage email, phone, WhatsApp, and address details.',
        ],
        'social' => [
            'label' => 'Social Links',
            'description' => 'Add social profile links, leave them blank, or use # as a placeholder.',
        ],
        'shipping' => [
            'label' => 'Shipping',
            'description' => 'Set the basic flat rate and free shipping threshold.',
        ],
        'payment' => [
            'label' => 'Payment',
            'description' => 'Enable or disable simple payment methods.',
        ],
        'tax' => [
            'label' => 'Tax',
            'description' => 'Set the default tax percentage.',
        ],
        'seo' => [
            'label' => 'SEO',
            'description' => 'Manage global SEO fallback values.',
        ],
    ];

    $knownGroups = ['general', 'admin', 'contact', 'social', 'shipping', 'payment', 'tax', 'seo'];
    $excludedGroups = ['theme', 'header', 'footer'];
    $orderedGroups = collect($knownGroups)
        ->filter(fn ($group) => $settings->has($group))
        ->merge($settings->keys()->diff([...$knownGroups, ...$excludedGroups]))
        ->values();
@endphp

@section('content')
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        @if ($orderedGroups->isNotEmpty())
            <div class="row g-4">
                <div class="col-lg-3">
                    <div class="list-group settings-nav position-sticky">
                        @foreach ($orderedGroups as $group)
                            @php
                                $meta = $groupMeta[$group] ?? [
                                    'label' => ucfirst(str_replace('_', ' ', $group)),
                                    'description' => null,
                                ];
                            @endphp
                            <a href="#{{ $group }}-settings" class="list-group-item list-group-item-action">
                                <span class="d-block fw-semibold">{{ $meta['label'] }}</span>
                                @if ($meta['description'])
                                    <span class="d-block small text-muted">{{ $meta['description'] }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-9">
                    @foreach ($orderedGroups as $group)
                        @php
                            $items = $settings->get($group);
                            $meta = $groupMeta[$group] ?? [
                                'label' => ucfirst(str_replace('_', ' ', $group)),
                                'description' => null,
                            ];
                        @endphp

                        <div id="{{ $group }}-settings" class="settings-section">
                            @include('admin.components.card', [
                                'title' => $meta['label'],
                                'subtitle' => $meta['description'],
                                'slot' => view('admin.settings._group', ['items' => $items])->render(),
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('admin.components.empty-state', [
                'title' => 'No settings found',
                'message' => 'Run the settings seeder to create editable store defaults.',
            ])
        @endif

        <div class="settings-actions d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
@endsection
