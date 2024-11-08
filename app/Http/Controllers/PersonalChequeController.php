<?php

namespace App\Http\Controllers;

use App\Models\PersonalCheque;
use App\Models\ChequeCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonalChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all records from ManualCheque
        $chequesCategory = PersonalCheque::all();
        // Define a static cheque name
        $chequeName = 'Personal Cheques';
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
        $validator = Validator::make($request->all(),[
            'categoriesName' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        if ($validator->fails()) {
            return redirect('admin/personalcheques')->with('error', $validator->errors());
        }

        $existingCheque = PersonalCheque::where('categoriesName', $request->categoriesName)->first();

        if ($existingCheque) {
            return redirect('admin/personalcheques')->with('error', 'categoriesName is already present');
        }

        $imageName = $request->file('image')->getClientOriginalName();

        $imagePath = public_path('assets/front/img/' . $imageName);
        
        $imageExists = file_exists($imagePath);
       
        if (!$imageExists) {
            $request->file('image')->move(public_path('assets/front/img'), $imageName);
        }

        PersonalCheque::create([
            'categoriesName' => $request->categoriesName,
            'img' => $imageName,
        ]);

        // Redirect or return a response as needed
        return redirect('admin/personalcheques')->with('success', 'Personal cheque created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the cheque categories by manual_cheque_id
        $chequeList = ChequeCategories::where('personal_cheque_id', $id)->get();

        // Set the cheque category name statically
        $chequeCategoryName = 'Personal Cheques';

        // Retrieve only the categoriesName from ManualCheque
        $chequeSubCategoryName = PersonalCheque::where('id', $id)->pluck('categoriesName')->first();

        // Pass the cheque, chequeCategoryName, and chequeSubCategoryName to the view
        return view('partials/chequesList', compact('chequeList', 'chequeCategoryName', 'chequeSubCategoryName'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $personalCheques = PersonalCheque::paginate(10);
        $chequesCategory = PersonalCheque::findOrFail($id);
        return view('admin/partials/dashboard/personal_cheques', compact('chequesCategory','personalCheques'));
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

        $personalCheque = PersonalCheque::findOrFail($id);

        $personalCheque->categoriesName = $request->categoriesName;

        if ($request->hasFile('image')) {
            $imageName = $request->file('image')->getClientOriginalName();

            $imagePath = public_path('assets/front/img/' . $imageName);
            
            $imageExists = file_exists($imagePath);
           
            if (!$imageExists) {
                $request->file('image')->move(public_path('assets/front/img'), $imageName);
            }

            $personalCheque->img = $imageName;

        }
        
        $personalCheque->save();
        // Redirect or return a response as needed
        return redirect('admin/personalcheques')->with('success', 'Personal cheque updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $personalCheque = PersonalCheque::findOrFail($id);
        $personalCheque->delete();
    
        return redirect('admin/personalcheques')->with('success', 'Personal cheque deleted successfully.');
    }
}
