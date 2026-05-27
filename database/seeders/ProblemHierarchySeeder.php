<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use App\Models\ProblemDetail;
use App\Models\ProblemSubcategory;
use Illuminate\Database\Seeder;

class ProblemHierarchySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Благоустройство' => [
                'Дворовые территории' => ['Ямы во дворе', 'Разрушенный бордюр', 'Неисправная детская площадка'],
                'Озеленение' => ['Сухие деревья', 'Необходима обрезка веток', 'Посадка новых насаждений'],
            ],
            'ЖКХ' => [
                'Водоснабжение' => ['Нет холодной воды', 'Нет горячей воды', 'Низкое давление воды'],
                'Отопление' => ['Нет отопления', 'Низкая температура в квартире', 'Протечка в системе отопления'],
            ],
            'Дороги и транспорт' => [
                'Дорожное покрытие' => ['Яма на проезжей части', 'Отсутствует разметка', 'Разрушение тротуара'],
                'Остановки и маршруты' => ['Неудобное расписание', 'Повреждена остановка', 'Нет информации о маршрутах'],
            ],
            'Освещение' => [
                'Уличное освещение' => ['Не горит фонарь', 'Мерцает освещение', 'Недостаточное освещение улицы'],
            ],
            'Санитарное состояние' => [
                'Вывоз мусора' => ['Переполненные контейнеры', 'Несанкционированная свалка', 'Нерегулярный вывоз мусора'],
            ],
            'Правопорядок' => [
                'Нарушение тишины' => ['Шум в ночное время', 'Громкая музыка во дворе'],
                'Вандализм' => ['Порча имущества', 'Граффити в неположенных местах'],
            ],
            'Иное' => [
                'Общие вопросы' => ['Иная проблема', 'Нужна консультация'],
            ],
        ];

        foreach ($tree as $categoryName => $subcategories) {
            $category = ProblemCategory::query()->where('name', $categoryName)->first();
            if (!$category) {
                continue;
            }

            $subcategoryOrder = 10;
            foreach ($subcategories as $subcategoryName => $details) {
                $subcategory = ProblemSubcategory::query()->updateOrCreate(
                    ['problem_category_id' => $category->id, 'name' => $subcategoryName],
                    ['sort_order' => $subcategoryOrder, 'is_active' => true]
                );
                $subcategoryOrder += 10;

                $detailOrder = 10;
                foreach ($details as $detailName) {
                    ProblemDetail::query()->updateOrCreate(
                        ['problem_subcategory_id' => $subcategory->id, 'name' => $detailName],
                        ['sort_order' => $detailOrder, 'is_active' => true]
                    );
                    $detailOrder += 10;
                }
            }
        }
    }
}
