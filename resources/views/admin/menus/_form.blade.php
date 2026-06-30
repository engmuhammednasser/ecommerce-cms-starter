<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @include('admin.components.form.input', [
        'name' => 'name',
        'label' => 'Name',
        'value' => $menu->name,
        'required' => true,
    ])

    @include('admin.components.form.input', [
        'name' => 'slug',
        'label' => 'Slug',
        'value' => $menu->slug,
    ])

    @include('admin.components.form.select', [
        'name' => 'location',
        'label' => 'Location',
        'selected' => $menu->location ?: 'header',
        'required' => true,
        'placeholder' => 'Choose location',
        'options' => \App\Models\Menu::LOCATIONS,
    ])

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.menus.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Menu</button>
    </div>
</form>
