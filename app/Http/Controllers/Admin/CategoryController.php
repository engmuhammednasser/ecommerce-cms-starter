<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()
            ->with('parent')
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

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category(['status' => 'draft', 'sort_order' => 0]),
            'parentOptions' => $this->parentOptions(),
            'mediaOptions' => \App\Models\Media::query()->where('mime_type', 'like', 'image/%')->orderBy('original_name')->pluck('original_name', 'id')->all(),
        ]);
    }

    public function store(Request $request, ActivityLogger $activityLogger): RedirectResponse
    {
        $category = Category::create($this->validatedData($request));
        $activityLogger->log('category_created', $category);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        $category->load('parent', 'children');

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'parentOptions' => $this->parentOptions($category),
            'mediaOptions' => \App\Models\Media::query()->where('mime_type', 'like', 'image/%')->orderBy('original_name')->pluck('original_name', 'id')->all(),
        ]);
    }

    public function update(Request $request, Category $category, ActivityLogger $activityLogger): RedirectResponse
    {
        $oldStatus = $category->status;
        $category->update($this->validatedData($request, $category));
        $activityLogger->log('category_updated', $category, [
            'status' => [$oldStatus, $category->status],
        ]);

        return redirect()
            ->route('admin.categories.show', $category)
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category, ActivityLogger $activityLogger): RedirectResponse
    {
        $activityLogger->log('category_deleted', $category);
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Category $category = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('name')));
        $request->merge(['slug' => $slug]);

        $parentRules = [
            'nullable',
            'integer',
            Rule::exists('categories', 'id'),
        ];

        if ($category) {
            $parentRules[] = Rule::notIn([$category->id]);
        }

        return $request->validate([
            'parent_id' => $parentRules,
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category?->id)],
            'image' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', Rule::in(array_keys(Category::STATUSES))],
            'sort_order' => ['required', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'seo_image' => ['nullable', 'string', 'max:255'],
            'cover_image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
            'icon_image_id' => ['nullable', 'integer', Rule::exists('media', 'id')],
        ]);
    }

    /**
     * @return array<int|string, string>
     */
    private function parentOptions(?Category $category = null): array
    {
        return Category::query()
            ->when($category, fn ($query) => $query->whereKeyNot($category->id))
            ->orderBy('sort_order')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->all();
    }
}
