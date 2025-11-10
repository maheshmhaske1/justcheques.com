<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('colors')->withCount('categories')->orderBy('id', 'desc')->get();
        return view('admin.partials.dashboard.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $colors = Color::where('is_active', true)->get();
        return view('admin.partials.dashboard.subcategories.create', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/front/img'), $imageName);
            $validated['image'] = $imageName;
        }

        $subcategory = Subcategory::create($validated);

        // Sync colors
        if ($request->has('colors')) {
            $subcategory->colors()->sync($request->colors);
        }

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $colors = Color::where('is_active', true)->get();
        $subcategory->load('colors');
        return view('admin.partials.dashboard.subcategories.edit', compact('subcategory', 'colors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($subcategory->image && file_exists(public_path('assets/front/img/' . $subcategory->image))) {
                unlink(public_path('assets/front/img/' . $subcategory->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/front/img'), $imageName);
            $validated['image'] = $imageName;
        }

        $subcategory->update($validated);

        // Sync colors
        if ($request->has('colors')) {
            $subcategory->colors()->sync($request->colors);
        } else {
            $subcategory->colors()->detach();
        }

        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        // Delete image if exists
        if ($subcategory->image && file_exists(public_path('assets/front/img/' . $subcategory->image))) {
            unlink(public_path('assets/front/img/' . $subcategory->image));
        }

        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }
}
