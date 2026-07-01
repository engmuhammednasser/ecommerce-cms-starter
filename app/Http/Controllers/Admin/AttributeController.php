<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttributeController extends Controller
{
    public function index(Request $request): View
    {
        $attributes = ProductAttribute::query()
            ->withCount('values')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request): void {
                $query->where('status', $request->string('status')->toString());
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.attributes.index', compact('attributes'));
    }

    public function create(): View
    {
        return view('admin.attributes.create', [
            'attribute' => new ProductAttribute(['type' => 'select', 'status' => 'active', 'sort_order' => 0]),
            'valuesText' => '',
        ]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        [$data, $valuesText] = $this->validatedData($request);
        $attribute = ProductAttribute::query()->create($data);
        $this->syncValues($attribute, $valuesText);
        $activityLogger->log('attribute_created', $attribute);

        return redirect()
            ->route('admin.attributes.show', $attribute)
            ->with('success', 'Attribute created successfully.');
    }

    public function show(ProductAttribute $attribute): View
    {
        $attribute->load('values');

        return view('admin.attributes.show', compact('attribute'));
    }

    public function edit(ProductAttribute $attribute): View
    {
        $attribute->load('values');

        return view('admin.attributes.edit', [
            'attribute' => $attribute,
            'valuesText' => $attribute->values->pluck('value')->implode(PHP_EOL),
        ]);
    }

    public function update(Request $request, ProductAttribute $attribute, ActivityLogger $activityLogger): RedirectResponse
    {
        [$data, $valuesText] = $this->validatedData($request, $attribute);
        $attribute->update($data);
        $this->syncValues($attribute, $valuesText);
        $activityLogger->log('attribute_updated', $attribute);

        return redirect()
            ->route('admin.attributes.show', $attribute)
            ->with('success', 'Attribute updated successfully.');
    }

    public function destroy(ProductAttribute $attribute, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('attribute_deleted', $attribute);
        $attribute->delete();

        return redirect()
            ->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully.');
    }

    /**
     * @return array{0: array<string, mixed>, 1: string}
     */
    private function validatedData(Request $request, ?ProductAttribute $attribute = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('name')));
        $request->merge(['slug' => $slug]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('attributes', 'slug')->ignore($attribute?->id)],
            'type' => ['required', 'string', Rule::in(array_keys(ProductAttribute::TYPES))],
            'status' => ['required', 'string', Rule::in(array_keys(ProductAttribute::STATUSES))],
            'sort_order' => ['required', 'integer', 'min:0'],
            'values' => ['nullable', 'string'],
        ]);

        $valuesText = (string) ($validated['values'] ?? '');
        unset($validated['values']);

        return [$validated, $valuesText];
    }

    private function syncValues(ProductAttribute $attribute, string $valuesText): void
    {
        $values = collect(preg_split('/\r\n|\r|\n/', $valuesText) ?: [])
            ->map(fn (string $value): string => trim($value))
            ->filter()
            ->unique()
            ->values();

        $attribute->values()->delete();

        $values->each(function (string $value, int $index) use ($attribute): void {
            $attribute->values()->create([
                'value' => $value,
                'slug' => Str::slug($value),
                'sort_order' => $index,
            ]);
        });
    }
}
