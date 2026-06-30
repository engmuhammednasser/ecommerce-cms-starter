<form method="GET" action="{{ route('admin.pages.index') }}">
    <div class="row align-items-end">
        <div class="col-md-6">
            @include('admin.components.form.input', [
                'name' => 'search',
                'label' => 'Search',
                'value' => request('search'),
            ])
        </div>
        <div class="col-md-4">
            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => request('status'),
                'placeholder' => 'All statuses',
                'options' => [
                    'draft' => 'Draft',
                    'published' => 'Published',
                    'archived' => 'Archived',
                ],
            ])
        </div>
        <div class="col-md-2 mb-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </div>
</form>
