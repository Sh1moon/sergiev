<?php

namespace App\Http\Controllers;

use App\Models\CouncilDeputy;

class CouncilDeputiesController extends Controller
{
    public function index()
    {
        $deputies = CouncilDeputy::orderBy('sort_order')->get();
        return view('council-deputies', compact('deputies'));
    }
}
