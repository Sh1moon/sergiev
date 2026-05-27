<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleSection;
use App\Models\CarouselSlide;
use App\Models\ProblemCategory;
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
        $problemCategories = ProblemCategory::query()
            ->where('is_active', true)
            ->with([
                'subcategories' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
                'subcategories.details' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')->orderBy('name'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('home', [
            'carouselSlides' => $carouselSlides,
            'latestNews' => $latestNews,
            'problemCategories' => $problemCategories,
        ]);
    }
}