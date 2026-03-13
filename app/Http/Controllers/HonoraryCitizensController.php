<?php

namespace App\Http\Controllers;

use App\Models\HonoraryCitizen;

class HonoraryCitizensController extends Controller
{
    public function index()
    {
        $items = HonoraryCitizen::orderBy('category')->orderBy('sort_order')->get();
        return view('honorary-citizens', compact('items'));
    }
}
