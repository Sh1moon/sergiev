<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProblemCategory;
use App\Models\ProblemDetail;
use App\Models\ProblemSubcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProblemCategoryController extends Controller
{
    public function index(): View
    {
        $categories = ProblemCategory::query()
            ->with([
                'subcategories' => fn ($q) => $q->withCount('appeals')->orderBy('sort_order')->orderBy('name'),
                'subcategories.details' => fn ($q) => $q->withCount('appeals')->orderBy('sort_order')->orderBy('name'),
            ])
            ->withCount('appeals')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.problem-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ProblemCategory::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Категория проблемы добавлена.');
    }

    public function update(Request $request, ProblemCategory $problemCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $problemCategory->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Категория проблемы обновлена.');
    }

    public function destroy(ProblemCategory $problemCategory): RedirectResponse
    {
        $problemCategory->delete();

        return back()->with('success', 'Категория проблемы удалена.');
    }

    public function storeSubcategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'problem_category_id' => ['required', 'exists:problem_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ProblemSubcategory::create([
            'problem_category_id' => (int) $data['problem_category_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Подкатегория добавлена.');
    }

    public function updateSubcategory(Request $request, ProblemSubcategory $problemSubcategory): RedirectResponse
    {
        $data = $request->validate([
            'problem_category_id' => ['required', 'exists:problem_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $problemSubcategory->update([
            'problem_category_id' => (int) $data['problem_category_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Подкатегория обновлена.');
    }

    public function destroySubcategory(ProblemSubcategory $problemSubcategory): RedirectResponse
    {
        $problemSubcategory->delete();

        return back()->with('success', 'Подкатегория удалена.');
    }

    public function storeDetail(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'problem_subcategory_id' => ['required', 'exists:problem_subcategories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        ProblemDetail::create([
            'problem_subcategory_id' => (int) $data['problem_subcategory_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Детальная проблема добавлена.');
    }

    public function updateDetail(Request $request, ProblemDetail $problemDetail): RedirectResponse
    {
        $data = $request->validate([
            'problem_subcategory_id' => ['required', 'exists:problem_subcategories,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $problemDetail->update([
            'problem_subcategory_id' => (int) $data['problem_subcategory_id'],
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return back()->with('success', 'Детальная проблема обновлена.');
    }

    public function destroyDetail(ProblemDetail $problemDetail): RedirectResponse
    {
        $problemDetail->delete();

        return back()->with('success', 'Детальная проблема удалена.');
    }
}
