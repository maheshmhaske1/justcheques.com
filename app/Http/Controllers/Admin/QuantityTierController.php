<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuantityTier;
use Illuminate\Http\Request;

class QuantityTierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quantityTiers = QuantityTier::orderBy('display_order')->get();
        return view('admin.partials.dashboard.quantity-tiers.index', compact('quantityTiers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.partials.dashboard.quantity-tiers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|unique:quantity_tiers,quantity',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        // Get the next display order if not provided
        if (!isset($validated['display_order'])) {
            $maxOrder = QuantityTier::max('display_order');
            $validated['display_order'] = $maxOrder ? $maxOrder + 1 : 1;
        }

        QuantityTier::create($validated);

        return redirect()->route('admin.quantity-tiers.index')
            ->with('success', 'Quantity tier created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuantityTier $quantityTier)
    {
        return view('admin.partials.dashboard.quantity-tiers.edit', compact('quantityTier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuantityTier $quantityTier)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|unique:quantity_tiers,quantity,' . $quantityTier->id,
            'display_order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $quantityTier->update($validated);

        return redirect()->route('admin.quantity-tiers.index')
            ->with('success', 'Quantity tier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuantityTier $quantityTier)
    {
        $quantityTier->delete();
        return redirect()->route('admin.quantity-tiers.index')
            ->with('success', 'Quantity tier deleted successfully.');
    }

    /**
     * Update display order for all quantity tiers
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'tiers' => 'required|array',
            'tiers.*.id' => 'required|exists:quantity_tiers,id',
            'tiers.*.display_order' => 'required|integer|min:0',
        ]);

        foreach ($validated['tiers'] as $tierData) {
            QuantityTier::where('id', $tierData['id'])->update([
                'display_order' => $tierData['display_order']
            ]);
        }

        return redirect()->route('admin.quantity-tiers.index')
            ->with('success', 'Display order updated successfully.');
    }
}
