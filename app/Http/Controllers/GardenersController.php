<?php

namespace App\Http\Controllers;

use App\Models\ArticleSection;
use Illuminate\Http\Request;

class GardenersController extends Controller
{
    public function index(Request $request)
    {
        $section = ArticleSection::where('slug', 'gardeners')->firstOrFail();
        $articles = $section->articles()
            ->published()
            ->with('user')
            ->orderByDesc('published_at')
            ->paginate(20);

        return view('gardeners', [
            'section' => $section,
            'articles' => $articles,
        ]);
    }
}
