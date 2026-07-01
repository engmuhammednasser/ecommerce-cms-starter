<form method="GET" action="{{ route('admin.users.index') }}" class="row g-3 align-items-end">
    <div class="col-md-8">
        @include('admin.components.form.input', [
            'name' => 'search',
            'label' => 'Search',
            'value' => request('search'),
        ])
    </div>

    <div class="col-md-4">
        <div class="mb-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>
