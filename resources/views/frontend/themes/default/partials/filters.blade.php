<form action="{{ url()->current() }}" method="GET" class="space-y-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
    @if(request('category') && request()->routeIs('catalog.shop'))
        <input type="hidden" name="category" value="{{ request('category') }}">
    @endif

    <div>
        <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-900">Search</h3>
        <div class="relative">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="w-full rounded-xl border border-slate-300 py-2.5 pl-10 pr-4 text-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            <svg class="absolute left-3.5 top-3 h-4 w-4 text-slate-400" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    @if (isset($categories) && $categories->count() > 0 && request()->routeIs('catalog.shop'))
        <div>
            <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-900">Categories</h3>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('catalog.shop', request()->except('category', 'page')) }}" class="block text-sm {{ !request('category') ? 'font-bold text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">All Categories</a>
                </li>
                @foreach ($categories as $cat)
                    <li>
                        <a href="{{ route('catalog.shop', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}" class="block text-sm {{ request('category') === $cat->slug ? 'font-bold text-slate-900' : 'text-slate-600 hover:text-slate-900' }}">{{ $cat->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-900">Price Range</h3>
        <div class="flex items-center gap-2">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
            <span class="text-slate-400">-</span>
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
        </div>
    </div>

    <div>
        <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-900">Availability</h3>
        <div class="space-y-3 text-sm">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                <span class="text-slate-700">In Stock</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }} class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                <span class="text-slate-700">On Sale</span>
            </label>
        </div>
    </div>

    <!-- Preserve sort -->
    @if(request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    <div class="pt-2">
        <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">Apply Filters</button>
        @if (request()->hasAny(['q', 'min_price', 'max_price', 'in_stock', 'on_sale', 'category']))
            <a href="{{ url()->current() }}" class="mt-3 block text-center text-sm font-medium text-slate-500 hover:text-slate-900">Clear All</a>
        @endif
    </div>
</form>
