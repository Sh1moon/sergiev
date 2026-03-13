<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlaceholderController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('placeholder');
    }
}
