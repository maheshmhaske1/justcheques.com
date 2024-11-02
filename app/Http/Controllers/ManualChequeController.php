<?php

namespace App\Http\Controllers;

use App\Models\ChequeCategories;
use App\Models\ManualCheque;
use Illuminate\Http\Request;

class ManualChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from ManualCheque
        $chequesCategory = ManualCheque::all();
        // Define a static cheque name
        $chequeName = 'Manual Cheques';
        return view('partials/chequesCategory', compact('chequesCategory', 'chequeName'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       
        $request->validate([
            'categoriesName' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
       
        $imageName = $request->file('image')->getClientOriginalName();

        $imagePath = public_path('assets/front/img/' . $imageName);
        
        $imageExists = file_exists($imagePath);
       
        if (!$imageExists) {
            $request->file('image')->move(public_path('assets/front/img'), $imageName);
        }

        ManualCheque::create([
            'categoriesName' => $request->categoriesName,
            'img' => $imageName,
        ]);

        // Redirect or return a response as needed
        return redirect('admin/manualcheques')->with('success', 'Manual cheque created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the cheque categories by manual_cheque_id
        $chequeList = ChequeCategories::where('manual_cheque_id', $id)->get();

        // Set the cheque category name statically
        $chequeCategoryName = 'Manual Cheques';

        // Retrieve only the categoriesName from ManualCheque
        $chequeSubCategoryName = ManualCheque::where('id', $id)->pluck('categoriesName')->first();

        // Pass the cheque, chequeCategoryName, and chequeSubCategoryName to the view
        return view('partials/chequesList', compact('chequeList', 'chequeCategoryName', 'chequeSubCategoryName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $manualCheques = ManualCheque::all();
        $chequesCategory = ManualCheque::findOrFail($id);
        return view('admin/partials/dashboard/manual_cheques', compact('chequesCategory','manualCheques'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request ,$id)
    {
        $request->validate([
            'categoriesName' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $manualCheque = ManualCheque::findOrFail($id);

        $manualCheque->categoriesName = $request->categoriesName;

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();

            $imagePath = public_path('assets/front/img/' . $imageName);
            
            $imageExists = file_exists($imagePath);
           
            if (!$imageExists) {
                $request->file('image')->move(public_path('assets/front/img'), $imageName);
            }

            $manualCheque->img = $imageName;

        }
        
        $manualCheque->save();
        // Redirect or return a response as needed
        return redirect('admin/manualcheques')->with('success', 'Manual cheque updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $manualCheque = ManualCheque::findOrFail($id);
        $manualCheque->delete();
    
        return redirect('admin/manualcheques')->with('success', 'Manual cheque deleted successfully.');
    }
}
