<?php

namespace App\Http\Controllers;

use App\Models\ArticleSection;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    /** Слаги разделов страницы «Документы», контент которых редактируется как статьи. */
    public const DOCUMENT_SECTION_SLUGS = [
        'investment',
        'resolutions',
        'anticorruption',
        'regulatory',
        'control',
        'expertise',
    ];

    public function index()
    {
        $sections = ArticleSection::whereIn('slug', self::DOCUMENT_SECTION_SLUGS)
            ->get()
            ->sortBy(fn ($s) => array_search($s->slug, self::DOCUMENT_SECTION_SLUGS, true))
            ->keyBy('slug');

        $articlesBySection = [];
        foreach (self::DOCUMENT_SECTION_SLUGS as $slug) {
            $section = $sections->get($slug);
            $articlesBySection[$slug] = $section
                ? $section->articles()->published()->orderByDesc('published_at')->limit(10)->get()
                : collect();
        }

        return view('documents', [
            'documentSectionSlugs' => self::DOCUMENT_SECTION_SLUGS,
            'documentSections' => $sections,
            'articlesBySection' => $articlesBySection,
        ]);
    }
}
