<form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-2 align-items-end">
    <div class="col-md-8">
        <label for="search" class="form-label">Search</label>
        <input
            type="search"
            id="search"
            name="search"
            value="{{ request('search') }}"
            class="form-control"
            placeholder="Search action, actor, or subject"
        >
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary">Reset</a>
    </div>
</form>
