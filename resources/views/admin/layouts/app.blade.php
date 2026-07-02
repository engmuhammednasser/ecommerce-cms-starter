<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    <style>
        body, .app-wrapper, .sidebar-wrapper, .app-header { font-family: 'Cairo', sans-serif !important; }
    </style>
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
