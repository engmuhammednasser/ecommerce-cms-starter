@extends('frontend.themes.default.layouts.app')

@section('title', 'Page not found')

@section('content')
    <section class="mx-auto flex max-w-6xl items-center px-6 py-20 sm:py-24">
        <div class="grid w-full gap-10 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm lg:grid-cols-[1fr_22rem] lg:items-center lg:p-12">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">404</p>
                <h1 class="mt-4 text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">
                    Page not found
                </h1>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-600">
                    The page you are looking for may have been moved, deleted, or is temporarily unavailable.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}" class="inline-flex rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                        Back to homepage
                    </a>
                    <a href="{{ route('catalog.shop') }}" class="inline-flex rounded-full border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-950 hover:bg-slate-950 hover:text-white">
                        Browse shop
                    </a>
                </div>
            </div>

            <div class="rounded-3xl bg-slate-950 p-8 text-white">
                <div class="text-7xl font-semibold leading-none">404</div>
                <p class="mt-6 text-sm leading-6 text-slate-300">
                    {{ setting('general.site_name', config('app.name', 'Laravel')) }}
                </p>
            </div>
        </div>
    </section>
@endsection
