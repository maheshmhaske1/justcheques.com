<?php

namespace App\Http\Controllers;

use App\Models\ChequeCategories;
use App\Models\LaserCheque;
use Illuminate\Http\Request;

class LaserChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from ManualCheque
        $chequesCategory = LaserCheque::all();
        // Define a static cheque name
        $chequeName = 'Laser Cheques';
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        
        $imageName = $request->file('image')->getClientOriginalName();

        $imagePath = public_path('assets/front/img/' . $imageName);
        
        $imageExists = file_exists($imagePath);
       
        if (!$imageExists) {
            $request->file('image')->move(public_path('assets/front/img'), $imageName);
        }

        LaserCheque::create([
            'categoriesName' => $request->categoriesName,
            'img' => $imageName,
        ]);

        // Redirect or return a response as needed
        return redirect('admin/lasercheques')->with('success', 'Manual cheque created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the cheque categories by manual_cheque_id
        $chequeList = ChequeCategories::where('laser_cheque_id', $id)->get();

        // Set the cheque category name statically
        $chequeCategoryName = 'Laser Cheques';

        // Retrieve only the categoriesName from ManualCheque
        $chequeSubCategoryName = LaserCheque::where('id', $id)->pluck('categoriesName')->first();
        
        // Pass the cheque, chequeCategoryName, and chequeSubCategoryName to the view
        return view('partials/chequesList', compact('chequeList', 'chequeCategoryName', 'chequeSubCategoryName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $laserCheques=LaserCheque::all();
        $chequesCategory = LaserCheque::findOrFail($id);
        return view('admin/partials/dashboard/laser_cheques', compact('chequesCategory','laserCheques'));
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

        $laserCheque = LaserCheque::findOrFail($id);

        $laserCheque->categoriesName = $request->categoriesName;

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();

            $imagePath = public_path('assets/front/img/' . $imageName);
            
            $imageExists = file_exists($imagePath);
           
            if (!$imageExists) {
                $request->file('image')->move(public_path('assets/front/img'), $imageName);
            }

            $laserCheque->img = $imageName;

        }
        
        $laserCheque->save();
        // Redirect or return a response as needed
        return redirect('admin/lasercheques')->with('success', 'Laser cheque updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laserCheque = LaserCheque::findOrFail($id);
        $laserCheque->delete();
    
        return redirect()->back()->with('success', 'Laser cheque deleted successfully.');
    }
}
