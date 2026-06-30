@extends('frontend.themes.default.layouts.app')

@section('title', $metaTitle ?? ($title ?? config('app.name', 'Laravel')))

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? null])

    <div class="mx-auto grid max-w-6xl gap-8 px-6 py-10 lg:grid-cols-[16rem_1fr]">
        <aside>
            @if ($categories->isNotEmpty())
                <nav aria-label="Product categories" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <a href="{{ route('catalog.shop') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-950">
                        {{ setting('catalog.all_categories_label', 'All categories') }}
                    </a>
                    @foreach ($categories as $categoryItem)
                        <a href="{{ route('catalog.categories.show', $categoryItem) }}" class="mt-2 block rounded-xl px-4 py-3 text-sm transition {{ $categoryItem->is($category) ? 'bg-slate-950 font-semibold text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950' }}">
                            {{ $categoryItem->name }}
                        </a>
                    @endforeach
                </nav>
            @endif
        </aside>

        <section>
            @if ($category->description)
                <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 leading-7 text-slate-600 shadow-sm">{!! nl2br(e($category->description)) !!}</div>
            @endif

            @if ($products->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center text-slate-600 shadow-sm">
                    {{ setting('catalog.empty_products_message', 'No products found.') }}
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($products as $product)
                        @include('frontend.themes.default.partials.catalog.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
