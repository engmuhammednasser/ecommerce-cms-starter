@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($page->meta_title ?? $page->title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $page->title ?? $title ?? null])

    @isset($page)
        <article class="mx-auto max-w-6xl px-6 py-8">
            {!! $page->content !!}
        </article>
    @endisset
@endsection
