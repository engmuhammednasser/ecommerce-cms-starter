@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            @include('frontend.themes.default.partials.filters', ['categories' => $categories])
        </aside>

        <section>
            @if ($products->isEmpty())
                @include('frontend.themes.default.components.empty-state', [
                    'title' => 'No products found.',
                    'message' => setting('catalog.empty_products_message', 'Try adjusting your filters or search query.')
                ])
            @else
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-slate-600">Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results</p>
                    @include('frontend.themes.default.partials.sort')
                </div>

                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($products as $product)
                        @include('frontend.themes.default.components.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
