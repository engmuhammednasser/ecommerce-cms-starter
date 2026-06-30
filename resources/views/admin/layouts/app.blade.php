<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        @include('admin.partials.header')
        @include('admin.partials.sidebar')

        <main class="app-main">
            @include('admin.partials.breadcrumb')

            <div class="app-content">
                <div class="container-fluid">
                    @include('admin.partials.flash')
                    @yield('content')
                </div>
            </div>
        </main>

        @include('admin.partials.footer')
    </div>

    @include('admin.components.media-picker-modal')
    @stack('scripts')
</body>
</html>
