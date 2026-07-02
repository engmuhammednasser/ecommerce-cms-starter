<form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3">
    <!-- Preserve existing filters -->
    @foreach(request()->except('sort', 'page') as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <label for="sort" class="text-sm font-medium text-slate-700">{{ __('store.sort_by') }}</label>
    <select name="sort" id="sort" onchange="this.form.submit()" class="rounded-xl border border-slate-300 py-2 pl-3 pr-8 text-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>{{ __('store.latest') }}</option>
        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('store.price_low_high') }}</option>
        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('store.price_high_low') }}</option>
        <option value="name_asc" {{ request('sort') === 'name_asc' ? 'selected' : '' }}>{{ __('store.name_a_z') }}</option>
        <option value="name_desc" {{ request('sort') === 'name_desc' ? 'selected' : '' }}>{{ __('store.name_z_a') }}</option>
    </select>
</form>
