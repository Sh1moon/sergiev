<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleSection;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Список статей по разделу (унифицированный вывод).
     * Маршрут задаётся через section slug, например news.index -> section news.
     */
    public function index(Request $request)
    {
        $sectionSlug = $request->route('sectionSlug', 'news');
        $section = ArticleSection::where('slug', $sectionSlug)->firstOrFail();
        $articles = $section->articles()
            ->published()
            ->with('user')
            ->orderByDesc('published_at')
            ->paginate(20);

        return view('articles.index', [
            'section' => $section,
            'articles' => $articles,
        ]);
    }

    /**
     * Детальная страница статьи (маршруты с одним параметром: news, finance, gosadmtechnadzor, information).
     * Ожидаемый раздел берётся из параметра маршрута (в т.ч. из defaults), если задан.
     */
    public function show(Request $request, Article $article)
    {
        $sectionSlug = $request->route('sectionSlug');
        return $this->showArticle($request, $article, $sectionSlug);
    }

    /**
     * Детальная страница статьи (маршрут /sections/{sectionSlug}/{article}).
     */
    public function showWithSection(Request $request, string $sectionSlug, Article $article)
    {
        return $this->showArticle($request, $article, $sectionSlug);
    }

    private function showArticle(Request $request, Article $article, ?string $sectionSlug): \Illuminate\View\View
    {
        if (!$article->published_at || $article->published_at->isFuture()) {
            abort(404);
        }
        $article->load('section', 'user', 'files');
        $section = $article->section;
        if ($sectionSlug !== null && $section->slug !== $sectionSlug) {
            abort(404);
        }

        return view('articles.show', [
            'section' => $section,
            'article' => $article,
        ]);
    }
}
