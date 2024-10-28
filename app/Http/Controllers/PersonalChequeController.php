<?php

namespace App\Http\Controllers;

use App\Models\PersonalCheque;
use App\Models\ChequeCategories;
use Illuminate\Http\Request;

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
        //
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
    public function edit(PersonalCheque $personalCheque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonalCheque $personalCheque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalCheque $personalCheque)
    {
        //
    }
}
