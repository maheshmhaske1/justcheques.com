<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('subcategories')->orderBy('id', 'desc')->get();
        return view('admin.partials.dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partials.dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.partials.dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Manage subcategories for a category
     */
    public function manageSubcategories(Category $category)
    {
        $assignedSubcategories = $category->subcategories()->withPivot('display_order')->orderBy('display_order')->get();
        $availableSubcategories = Subcategory::whereNotIn('id', $assignedSubcategories->pluck('id'))->get();

        return view('admin.partials.dashboard.categories.manage-subcategories', compact('category', 'assignedSubcategories', 'availableSubcategories'));
    }

    /**
     * Assign subcategory to category
     */
    public function assignSubcategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'display_order' => 'nullable|integer|min:0',
        ]);

        // Get the next display order if not provided
        if (!isset($validated['display_order'])) {
            $maxOrder = $category->subcategories()->max('display_order');
            $validated['display_order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        $category->subcategories()->attach($validated['subcategory_id'], [
            'display_order' => $validated['display_order']
        ]);

        return redirect()->route('admin.categories.manage-subcategories', $category)
            ->with('success', 'Subcategory assigned successfully.');
    }

    /**
     * Remove subcategory from category
     */
    public function removeSubcategory(Category $category, Subcategory $subcategory)
    {
        $category->subcategories()->detach($subcategory->id);

        return redirect()->route('admin.categories.manage-subcategories', $category)
            ->with('success', 'Subcategory removed successfully.');
    }

    /**
     * Update display order for subcategories
     */
    public function updateSubcategoryOrder(Request $request, Category $category)
    {
        $validated = $request->validate([
            'subcategories' => 'required|array',
            'subcategories.*.id' => 'required|exists:subcategories,id',
            'subcategories.*.display_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['subcategories'] as $subcategoryData) {
            $category->subcategories()->updateExistingPivot($subcategoryData['id'], [
                'display_order' => $subcategoryData['display_order']
            ]);
        }

        return redirect()->route('admin.categories.manage-subcategories', $category)
            ->with('success', 'Display order updated successfully.');
    }
}
