<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $carouselSlides = CarouselSlide::orderBy('sort_order')->get();
        $newsSection = ArticleSection::where('slug', ArticleSection::slugNews())->first();
        $latestNews = $newsSection
            ? $newsSection->articles()->published()->orderByDesc('published_at')->limit(5)->get()
            : collect();

        return view('home', [
            'carouselSlides' => $carouselSlides,
            'latestNews' => $latestNews,
        ]);
    }
}