<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\Subcategory;
use App\Models\QuantityTier;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display a listing of all pricing
     */
    public function index()
    {
        $subcategories = Subcategory::with(['pricing.quantityTier'])->get();
        return view('admin.partials.dashboard.pricing.index', compact('subcategories'));
    }

    /**
     * Manage pricing for a specific subcategory
     */
    public function manageSubcategory(Subcategory $subcategory)
    {
        $quantityTiers = QuantityTier::orderBy('display_order')->get();
        $existingPricing = $subcategory->pricing()->with('quantityTier')->get()->keyBy('quantity_tier_id');

        return view('admin.partials.dashboard.pricing.manage', compact('subcategory', 'quantityTiers', 'existingPricing'));
    }

    /**
     * Store or update pricing for a subcategory
     */
    public function updateSubcategoryPricing(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'prices' => 'required|array',
            'prices.*' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['prices'] as $quantityTierId => $price) {
            if ($price === null || $price === '') {
                // Remove pricing if empty
                Pricing::where('subcategory_id', $subcategory->id)
                    ->where('quantity_tier_id', $quantityTierId)
                    ->delete();
            } else {
                // Update or create pricing
                Pricing::updateOrCreate(
                    [
                        'subcategory_id' => $subcategory->id,
                        'quantity_tier_id' => $quantityTierId,
                    ],
                    [
                        'price' => $price,
                    ]
                );
            }
        }

        return redirect()->route('admin.pricing.manage-subcategory', $subcategory)
            ->with('success', 'Pricing updated successfully.');
    }

    /**
     * Bulk manage all pricing
     */
    public function bulkManage()
    {
        $subcategories = Subcategory::with(['pricing.quantityTier'])->get();
        $quantityTiers = QuantityTier::orderBy('display_order')->get();

        return view('admin.partials.dashboard.pricing.bulk-manage', compact('subcategories', 'quantityTiers'));
    }

    /**
     * Update bulk pricing
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'pricing' => 'required|array',
            'pricing.*.*' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['pricing'] as $subcategoryId => $prices) {
            foreach ($prices as $quantityTierId => $price) {
                if ($price === null || $price === '') {
                    // Remove pricing if empty
                    Pricing::where('subcategory_id', $subcategoryId)
                        ->where('quantity_tier_id', $quantityTierId)
                        ->delete();
                } else {
                    // Update or create pricing
                    Pricing::updateOrCreate(
                        [
                            'subcategory_id' => $subcategoryId,
                            'quantity_tier_id' => $quantityTierId,
                        ],
                        [
                            'price' => $price,
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.pricing.bulk-manage')
            ->with('success', 'All pricing updated successfully.');
    }

    /**
     * Delete a specific pricing entry
     */
    public function destroy(Pricing $pricing)
    {
        $subcategory = $pricing->subcategory;
        $pricing->delete();

        return redirect()->route('admin.pricing.manage-subcategory', $subcategory)
            ->with('success', 'Pricing deleted successfully.');
    }
}
