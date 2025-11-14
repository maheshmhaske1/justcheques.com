<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubcategoryItem;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = SubcategoryItem::with('subcategory')->orderBy('id', 'desc')->get();
        return view('admin.partials.dashboard.subcategory-items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.partials.dashboard.subcategory-items.create', compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        SubcategoryItem::create($validated);

        return redirect()->route('admin.subcategory-items.index')
            ->with('success', 'Subcategory item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubcategoryItem $subcategoryItem)
    {
        $subcategories = Subcategory::where('is_active', true)->orderBy('name')->get();
        return view('admin.partials.dashboard.subcategory-items.edit', compact('subcategoryItem', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubcategoryItem $subcategoryItem)
    {
        $validated = $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $subcategoryItem->update($validated);

        return redirect()->route('admin.subcategory-items.index')
            ->with('success', 'Subcategory item updated successfully.');
    }

    /**
     * Toggle the active status of the item.
     */
    public function destroy(SubcategoryItem $subcategoryItem)
    {
        // Toggle is_active instead of deleting
        $subcategoryItem->update(['is_active' => !$subcategoryItem->is_active]);

        $status = $subcategoryItem->is_active ? 'enabled' : 'disabled';
        return redirect()->route('admin.subcategory-items.index')
            ->with('success', "Subcategory item {$status} successfully.");
    }
}
