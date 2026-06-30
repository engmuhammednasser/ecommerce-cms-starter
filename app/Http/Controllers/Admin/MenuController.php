<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        $menus = Menu::query()
            ->withCount('items')
            ->orderBy('location')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.menus.index', compact('menus'));
    }

    public function create(): View
    {
        return view('admin.menus.create', ['menu' => new Menu(['location' => 'header'])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $menu = Menu::create($this->validatedMenuData($request));

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu): View
    {
        $menu->load(['items.parent']);

        return view('admin.menus.show', [
            'menu' => $menu,
            'parentItems' => $this->parentItemOptions($menu),
        ]);
    }

    public function edit(Menu $menu): View
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $menu->update($this->validatedMenuData($request, $menu));

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }

    public function storeItem(Request $request, Menu $menu): RedirectResponse
    {
        $menu->items()->create($this->validatedItemData($request, $menu));

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu item added successfully.');
    }

    public function destroyItem(Menu $menu, MenuItem $item): RedirectResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);

        $item->delete();

        return redirect()
            ->route('admin.menus.show', $menu)
            ->with('success', 'Menu item deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedMenuData(Request $request, ?Menu $menu = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('name')));
        $request->merge(['slug' => $slug]);

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('menus', 'slug')->ignore($menu?->id)],
            'location' => ['required', 'string', Rule::in(array_keys(Menu::LOCATIONS))],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedItemData(Request $request, Menu $menu): array
    {
        $validated = $request->validate([
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('menu_items', 'id')->where(fn ($query) => $query->where('menu_id', $menu->id)),
            ],
            'label' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', Rule::in(array_keys(MenuItem::TYPES))],
            'reference_id' => ['nullable', 'integer', 'min:1'],
            'url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        if ($validated['type'] === 'page') {
            $request->validate(['reference_id' => ['required', 'integer', 'exists:pages,id']]);
            $page = Page::find($validated['reference_id']);
            $validated['url'] = $page ? '/'.$page->slug : null;
        }

        if ($validated['type'] === 'custom') {
            $request->validate(['url' => ['required', 'string', 'max:255']]);
            $validated['reference_id'] = null;
        }

        return $validated;
    }

    /**
     * @return array<int|string, string>
     */
    private function parentItemOptions(Menu $menu): array
    {
        return $menu->items()
            ->whereNull('parent_id')
            ->pluck('label', 'id')
            ->all();
    }
}
