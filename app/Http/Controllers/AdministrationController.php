<?php

namespace App\Http\Controllers;

use App\Models\AdministrationHead;
use App\Models\AdministrationDeputy;
use App\Models\AdministrationDepartment;
use App\Models\AdministrationInstitution;
use App\Models\AdministrationTerritory;
use App\Models\AdministrationGoChs;

class AdministrationController extends Controller
{
    public function index()
    {
        $head = AdministrationHead::first();
        $deputies = AdministrationDeputy::orderBy('sort_order')->orderBy('id')->get();
        $departments = AdministrationDepartment::orderBy('sort_order')->get();
        $institutions = AdministrationInstitution::orderBy('sort_order')->get();
        $territories = AdministrationTerritory::orderBy('sort_order')->get();
        $goChs = AdministrationGoChs::first();

        return view('administration', compact('head', 'deputies', 'departments', 'institutions', 'territories', 'goChs'));
    }
}
