@extends('frontend.themes.default.layouts.app')

@section('title', $title ?? 'Saved Addresses')

@section('content')
    @include('frontend.themes.default.partials.page-header', ['title' => $title ?? 'Saved Addresses'])

    <div class="mx-auto max-w-6xl px-6 py-10">
        <div class="grid gap-10 lg:grid-cols-[16rem_1fr]">
            <aside>
                @include('frontend.themes.default.customer.partials.sidebar')
            </aside>

            <div class="space-y-8">
                @if (session('success'))
                    <div class="rounded-xl bg-emerald-50 p-4 text-sm font-medium text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2">
                    @foreach ($addresses as $address)
                        <div class="relative rounded-3xl border {{ $address->is_default ? 'border-slate-900 ring-1 ring-slate-900' : 'border-slate-200' }} bg-white p-6 shadow-sm">
                            @if ($address->is_default)
                                <span class="absolute right-6 top-6 inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800">Default</span>
                            @endif
                            <h3 class="mb-2 font-bold text-slate-900">{{ $address->label ?: 'Address' }}</h3>
                            <div class="mb-6 whitespace-pre-wrap text-sm text-slate-600">{{ $address->address }}</div>
                            <form method="POST" action="{{ route('customer.addresses.destroy', $address) }}" onsubmit="return confirm('Are you sure you want to delete this address?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
                    <h3 class="mb-6 text-lg font-bold text-slate-900">Add New Address</h3>
                    <form action="{{ route('customer.addresses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="label" class="mb-2 block text-sm font-medium text-slate-700">Label (e.g. Home, Office)</label>
                            <input type="text" id="label" name="label" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                        </div>
                        <div>
                            <label for="address" class="mb-2 block text-sm font-medium text-slate-700">Full Address</label>
                            <textarea id="address" name="address" rows="3" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"></textarea>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="is_default" name="is_default" value="1" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                            <label for="is_default" class="text-sm text-slate-700">Set as default address</label>
                        </div>
                        <button type="submit" class="rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Save Address
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
