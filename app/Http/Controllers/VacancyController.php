<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use Illuminate\Http\Request;

class VacancyController extends Controller
{
    public function show(Vacancy $vacancy)
    {
        if (!$vacancy->published_at || $vacancy->published_at->isFuture()) {
            abort(404);
        }
        return view('vacancy.show', compact('vacancy'));
    }
}
