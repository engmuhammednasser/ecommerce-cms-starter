<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $seoTitle = $metaTitle ?? trim($__env->yieldContent('title', config('app.name', 'Laravel')));
            $seoDescription = $metaDescription ?? setting('seo.default_description');
            $seoImage = $metaImage ?? null;
            $seoCanonical = $canonicalUrl ?? url()->current();
            $seoRobots = $metaRobots ?? 'index, follow';
        @endphp

        <title>{{ $seoTitle }}</title>
        @if ($seoDescription)
            <meta name="description" content="{{ $seoDescription }}">
        @endif
        @if ($seoCanonical)
            <link rel="canonical" href="{{ $seoCanonical }}">
        @endif
        @if ($seoRobots)
            <meta name="robots" content="{{ $seoRobots }}">
        @endif
        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $seoTitle }}">
        @if ($seoDescription)
            <meta property="og:description" content="{{ $seoDescription }}">
        @endif
        @if ($seoImage)
            <meta property="og:image" content="{{ $seoImage }}">
        @endif
        @if ($seoCanonical)
            <meta property="og:url" content="{{ $seoCanonical }}">
        @endif
        <meta name="twitter:card" content="{{ $seoImage ? 'summary_large_image' : 'summary' }}">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        @if ($seoDescription)
            <meta name="twitter:description" content="{{ $seoDescription }}">
        @endif
        @if ($seoImage)
            <meta name="twitter:image" content="{{ $seoImage }}">
        @endif

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-950 antialiased">
        @include('frontend.themes.default.partials.header')

        <main id="content" class="min-h-[60vh]">
            @yield('content')
        </main>

        @include('frontend.themes.default.partials.footer')

        @stack('scripts')
    </body>
</html>
