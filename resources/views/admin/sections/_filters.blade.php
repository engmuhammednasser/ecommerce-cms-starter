<form method="GET" action="{{ route('admin.sections.index') }}">
    <div class="row align-items-end">
        <div class="col-md-4">
            @include('admin.components.form.input', [
                'name' => 'search',
                'label' => 'Search',
                'value' => request('search'),
            ])
        </div>
        <div class="col-md-3">
            @include('admin.components.form.select', [
                'name' => 'type',
                'label' => 'Type',
                'selected' => request('type'),
                'placeholder' => 'All types',
                'options' => \App\Models\PageSection::TYPES,
            ])
        </div>
        <div class="col-md-3">
            @include('admin.components.form.select', [
                'name' => 'is_active',
                'label' => 'State',
                'selected' => request('is_active'),
                'placeholder' => 'All states',
                'options' => [
                    '1' => 'Active',
                    '0' => 'Inactive',
                ],
            ])
        </div>
        <div class="col-md-2 mb-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>
