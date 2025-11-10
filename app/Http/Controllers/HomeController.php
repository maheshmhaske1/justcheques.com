<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ChequeCategories;
use App\Models\Color;
use App\Models\Customer;
use App\Models\Pricing;
use App\Models\QuantityTier;

class HomeController extends Controller
{
    public function index()
    {
        // Get active categories with their subcategories
        $categories = Category::where('is_active', true)
            ->with(['subcategories' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('category_subcategory.display_order');
            }])
            ->get();

        return view('partials.home', compact('categories'));
    }

    public function show($slug)
    {
        // Find category by slug
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->with(['subcategories' => function($query) {
                $query->where('is_active', true)
                      ->with(['pricing' => function($pricingQuery) {
                          $pricingQuery->join('quantity_tiers', 'pricing.quantity_tier_id', '=', 'quantity_tiers.id')
                                       ->where('quantity_tiers.is_active', true)
                                       ->orderBy('quantity_tiers.display_order', 'asc')
                                       ->select('pricing.*');
                      }])
                      ->orderBy('category_subcategory.display_order');
            }])
            ->firstOrFail();

        // Get all active subcategories for this category and add lowest price
        $subcategories = $category->subcategories->map(function($subcategory) {
            $lowestPrice = $subcategory->pricing->min('price');
            $subcategory->lowest_price = $lowestPrice ?? 0;
            return $subcategory;
        });

        // Return the appropriate view based on the category
        // This will display all subcategories under this category
        return view('partials.category-show', compact('category', 'subcategories'));
    }

    public function makeOrder($id)
    {
        // Find subcategory by ID
        $subcategory = Subcategory::where('id', $id)
            ->where('is_active', true)
            ->with(['pricing.quantityTier' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('display_order', 'asc');
            }, 'colors' => function($query) {
                $query->where('is_active', true)
                      ->orderBy('name');
            }])
            ->firstOrFail();

        // Get the category for this subcategory
        $category = $subcategory->categories()->where('is_active', true)->first();

        if (!$category) {
            abort(404, 'Category not found');
        }

        // Get customers and colors (only colors attached to this subcategory)
        $customers = Customer::all();
        $colors = $subcategory->colors;

        // Get quantity tiers with pricing for this subcategory
        $quantityTiers = QuantityTier::where('is_active', true)
            ->orderBy('display_order')
            ->get();

        // Sort pricing by quantity tier display order
        $subcategory->pricing = $subcategory->pricing->sortBy(function($pricing) {
            return $pricing->quantityTier ? $pricing->quantityTier->display_order : 999;
        });

        $chequeCategoryName = $category->name;
        $chequeSubCategoryName = $subcategory->name;

        // Return the order form view
        return view('partials.subcategoryOrder', compact(
            'subcategory',
            'category',
            'chequeCategoryName',
            'chequeSubCategoryName',
            'customers',
            'colors',
            'quantityTiers'
        ));
    }
}
