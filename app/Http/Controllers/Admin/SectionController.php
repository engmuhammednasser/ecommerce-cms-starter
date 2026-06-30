<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SectionController extends Controller
{
    public function index(Request $request): View
    {
        $sections = PageSection::query()
            ->with('page')
            ->when($request->filled('search'), function ($query) use ($request): void {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('type'), function ($query) use ($request): void {
                $query->where('type', $request->string('type')->toString());
            })
            ->when($request->filled('is_active'), function ($query) use ($request): void {
                $query->where('is_active', $request->boolean('is_active'));
            })
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.sections.index', compact('sections'));
    }

    public function create(): View
    {
        return view('admin.sections.create', [
            'section' => new PageSection(['is_active' => true, 'sort_order' => 0]),
            'pages' => $this->pageOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $section = PageSection::create($this->validatedData($request));

        return redirect()
            ->route('admin.sections.show', $section)
            ->with('success', 'Homepage section created successfully.');
    }

    public function show(PageSection $section): View
    {
        $section->load('page');

        return view('admin.sections.show', compact('section'));
    }

    public function edit(PageSection $section): View
    {
        return view('admin.sections.edit', [
            'section' => $section,
            'pages' => $this->pageOptions(),
        ]);
    }

    public function update(Request $request, PageSection $section): RedirectResponse
    {
        $section->update($this->validatedData($request));

        return redirect()
            ->route('admin.sections.show', $section)
            ->with('success', 'Homepage section updated successfully.');
    }

    public function destroy(PageSection $section): RedirectResponse
    {
        $section->delete();

        return redirect()
            ->route('admin.sections.index')
            ->with('success', 'Homepage section deleted successfully.');
    }

    /**
     * @return array<int|string, string>
     */
    private function pageOptions(): array
    {
        return Page::query()
            ->orderBy('title')
            ->pluck('title', 'id')
            ->all();
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $validated = $request->validate([
            'page_id' => ['nullable', 'integer', 'exists:pages,id'],
            'type' => ['required', 'string', Rule::in(array_keys(PageSection::TYPES))],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'settings' => ['nullable', 'json'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['settings'] = filled($validated['settings'] ?? null)
            ? json_decode((string) $validated['settings'], true)
            : null;

        return $validated;
    }
}
