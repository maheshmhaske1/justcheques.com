<?php

namespace App\Http\Controllers;
use App\Models\ManualCheque;
use App\Models\LaserCheque;
use App\Models\PersonalCheque;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function manual_cheques() {
        $manualCheques = ManualCheque::paginate(10);
        return view('admin/partials/dashboard/manual_cheques', compact('manualCheques'));
    }


    public function laser_cheques() {
        $laserCheques = LaserCheque::paginate(10);
        return view('admin/partials/dashboard/laser_cheques', compact('laserCheques'));
    }


    public function personal_cheques() {
        $personalCheques = PersonalCheque::paginate(10);
        return view('admin/partials/dashboard/personal_cheques', compact('personalCheques'));
    }



    //all cheque form

    // public function add_manual_cheques_form(){
    //     return view('admin/partials/dashboard/add_manual_cheques_form');
    // }
    // public function add_laser_cheques_form(){
    //     return view('admin/partials/dashboard/add_laser_cheques_form');
    // }
    // public function add_personal_cheques_form(){
    //     return view('admin/partials/dashboard/add_personal_cheques_form');
    // }
}
