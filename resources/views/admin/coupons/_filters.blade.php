<form method="GET" action="{{ route('admin.coupons.index') }}" class="row g-3 align-items-end">
    <div class="col-md-6">
        @include('admin.components.form.input', [
            'name' => 'search',
            'label' => 'Search',
            'value' => request('search'),
        ])
    </div>
    <div class="col-md-3">
        @include('admin.components.form.select', [
            'name' => 'status',
            'label' => 'Status',
            'selected' => request('status'),
            'placeholder' => 'Any status',
            'options' => \App\Models\Coupon::STATUSES,
        ])
    </div>
    <div class="col-md-3">
        <div class="mb-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>
