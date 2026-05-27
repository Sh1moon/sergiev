<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Seeder;

class ProblemCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Благоустройство', 'description' => 'Дворы, тротуары, детские площадки', 'sort_order' => 10],
            ['name' => 'ЖКХ', 'description' => 'Вода, отопление, канализация, подъезды', 'sort_order' => 20],
            ['name' => 'Дороги и транспорт', 'description' => 'Ямы, разметка, остановки, маршруты', 'sort_order' => 30],
            ['name' => 'Освещение', 'description' => 'Уличное освещение и дворовые фонари', 'sort_order' => 40],
            ['name' => 'Санитарное состояние', 'description' => 'Мусор, свалки, уборка территории', 'sort_order' => 50],
            ['name' => 'Правопорядок', 'description' => 'Шум, вандализм, нарушения порядка', 'sort_order' => 60],
            ['name' => 'Иное', 'description' => 'Прочие вопросы', 'sort_order' => 999],
        ];

        foreach ($categories as $item) {
            ProblemCategory::query()->updateOrCreate(
                ['name' => $item['name']],
                ['description' => $item['description'], 'sort_order' => $item['sort_order'], 'is_active' => true]
            );
        }
    }
}
