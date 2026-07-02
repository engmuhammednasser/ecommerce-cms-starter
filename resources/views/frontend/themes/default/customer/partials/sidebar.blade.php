<nav class="space-y-1">
    <a href="{{ route('customer.dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('customer.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        Dashboard
    </a>
    <a href="{{ route('customer.orders') }}" class="block rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('customer.orders') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        Order History
    </a>
    <a href="{{ route('customer.addresses') }}" class="block rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs('customer.addresses') ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
        Saved Addresses
    </a>
    <form method="POST" action="{{ route('customer.logout') }}" class="block">
        @csrf
        <button type="submit" class="w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50">
            Log out
        </button>
    </form>
</nav>
