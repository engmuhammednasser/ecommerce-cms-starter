@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            @include('frontend.themes.default.partials.filters', ['categories' => $categories])
        </aside>

        <section>
            {{-- Top-level categories navigation --}}
            @if(isset($categories) && $categories->count() > 0)
                <div class="mb-8">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 mb-4">{{ __('store.shop_categories') }}</h2>
                    <div class="flex flex-wrap gap-3">
                        @foreach($categories as $cat)
                            <a href="{{ route('catalog.categories.show', $cat) }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            @if ($products->isEmpty())
                @include('frontend.themes.default.components.empty-state', [
                    'title' => __('store.no_products_found'),
                    'message' => setting('catalog.empty_products_message', __('store.empty_products_message')),
                    'actionText' => __('store.clear_all_filters'),
                    'actionUrl' => route('catalog.shop')
                ])
            @else
                <div class="mb-6 flex items-center justify-between">
                    <p class="text-sm text-slate-600">{{ __('store.showing') }} {{ $products->firstItem() ?? 0 }} {{ __('store.to') }} {{ $products->lastItem() ?? 0 }} {{ __('store.of') }} {{ $products->total() }} {{ __('store.results') }}</p>
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
