<?php

namespace Database\Seeders;

use App\Models\ArticleSection;
use Illuminate\Database\Seeder;

class ArticleSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            ['slug' => 'news', 'name' => 'Новости', 'route_name' => 'news.index', 'sort_order' => 1],
            ['slug' => 'information', 'name' => 'Информация', 'route_name' => 'information', 'sort_order' => 2],
            ['slug' => 'gosadmtechnadzor', 'name' => 'Госадмтехнадзор', 'route_name' => 'gosadmtechnadzor', 'sort_order' => 3],
            ['slug' => 'competition', 'name' => 'Развитие конкуренции', 'route_name' => 'competition', 'sort_order' => 4],
            ['slug' => 'organizations', 'name' => 'Общественные организации', 'route_name' => 'organizations', 'sort_order' => 5],
            ['slug' => 'activities', 'name' => 'Деятельность', 'route_name' => 'activities', 'sort_order' => 6],
            ['slug' => 'gardeners', 'name' => 'Дачникам и садоводам', 'route_name' => 'gardeners', 'sort_order' => 7],
            ['slug' => 'go-chs', 'name' => 'ГО и ЧС', 'route_name' => 'go-chs', 'sort_order' => 8],
            ['slug' => 'finance', 'name' => 'Финансы', 'route_name' => 'finance', 'sort_order' => 9],
            // Подразделы страницы «Финансы» (работают как новости)
            ['slug' => 'forecast', 'name' => 'Прогноз социально-экономического развития Сергиево-Посадского городского округа Московской области', 'route_name' => 'finance.section', 'sort_order' => 10],
            ['slug' => 'report', 'name' => 'Доклад Главы', 'route_name' => 'finance.section', 'sort_order' => 11],
            ['slug' => 'programs', 'name' => 'Программы', 'route_name' => 'finance.section', 'sort_order' => 12],
            ['slug' => 'programs-archive', 'name' => 'Архив программ', 'route_name' => 'finance.section', 'sort_order' => 13],
            ['slug' => 'social-partnership', 'name' => 'Социальное партнерство', 'route_name' => 'finance.section', 'sort_order' => 14],
            // Разделы страницы «Документы» (редактируемые как новости)
            ['slug' => 'investment', 'name' => 'Инвестиции', 'route_name' => 'articles.index', 'sort_order' => 20],
            ['slug' => 'resolutions', 'name' => 'Постановления', 'route_name' => 'articles.index', 'sort_order' => 21],
            ['slug' => 'anticorruption', 'name' => 'Антикоррупция', 'route_name' => 'articles.index', 'sort_order' => 22],
            ['slug' => 'regulatory', 'name' => 'Оценка регулирующего воздействия', 'route_name' => 'articles.index', 'sort_order' => 23],
            ['slug' => 'control', 'name' => 'Муниципальный контроль', 'route_name' => 'articles.index', 'sort_order' => 24],
            ['slug' => 'expertise', 'name' => 'ОФВ и экспертиза', 'route_name' => 'articles.index', 'sort_order' => 25],
        ];

        foreach ($sections as $section) {
            ArticleSection::updateOrCreate(
                ['slug' => $section['slug']],
                $section
            );
        }
    }
}
