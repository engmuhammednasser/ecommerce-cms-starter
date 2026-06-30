@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? config('app.name', 'Laravel'))

@section('content')
    @foreach ($sections ?? [] as $section)
        @includeIf('frontend.themes.default.sections.' . $section->type, ['section' => $section])
    @endforeach
@endsection
