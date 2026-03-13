<?php

namespace App\Http\Controllers;

use App\Models\ArticleSection;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /** Слаги подразделов страницы «Финансы» (списки статей как в новостях). */
    public const FINANCE_SECTION_SLUGS = [
        'finance',
        'forecast',
        'report',
        'programs',
        'programs-archive',
        'social-partnership',
    ];

    /** Названия подразделов (для отображения без зависимости от БД). */
    public const FINANCE_SECTION_NAMES = [
        'finance' => 'Финансы',
        'forecast' => 'Прогноз социально-экономического развития Сергиево-Посадского городского округа Московской области',
        'report' => 'Доклад Главы',
        'programs' => 'Программы',
        'programs-archive' => 'Архив программ',
        'social-partnership' => 'Социальное партнерство',
    ];

    public function index()
    {
        $sections = ArticleSection::whereIn('slug', self::FINANCE_SECTION_SLUGS)
            ->get()
            ->sortBy(fn ($s) => array_search($s->slug, self::FINANCE_SECTION_SLUGS, true))
            ->keyBy('slug');

        $articlesBySection = [];
        foreach (self::FINANCE_SECTION_SLUGS as $slug) {
            $section = $sections->get($slug);
            $articlesBySection[$slug] = $section
                ? $section->articles()->published()->orderByDesc('published_at')->limit(10)->get()
                : collect();
        }

        return view('finance', [
            'financeSectionSlugs' => self::FINANCE_SECTION_SLUGS,
            'financeSections' => $sections,
            'financeSectionNames' => self::FINANCE_SECTION_NAMES,
            'articlesBySection' => $articlesBySection,
        ]);
    }
}
