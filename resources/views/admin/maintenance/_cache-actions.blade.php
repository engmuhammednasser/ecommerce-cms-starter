<p class="text-muted">
    These actions only clear Laravel cache files and cached values. They do not delete content, orders, customers, products, media, or database records.
</p>

<div class="d-grid gap-2">
    @foreach ($clearActions as $target => $action)
        <form method="POST" action="{{ route('admin.maintenance.clear') }}" onsubmit="return confirm(@js('Clear ' . $action['label'] . '?'))">
            @csrf
            <input type="hidden" name="target" value="{{ $target }}">
            <button type="submit" class="btn btn-outline-primary w-100">
                Clear {{ $action['label'] }}
            </button>
        </form>
    @endforeach
</div>
