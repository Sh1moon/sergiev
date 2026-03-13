<?php

namespace Database\Seeders;

use App\Models\AdministrationInstitution;
use Illuminate\Database\Seeder;

class AdministrationInstitutionsSeeder extends Seeder
{
    public function run(): void
    {
        if (AdministrationInstitution::exists()) {
            return;
        }

        $rows = [
            ['title' => 'МБУ «Центр культуры и досуга „Мир"»', 'leader' => 'директор — Филимонова Ольга Николаевна', 'address' => 'г. Сергиев Посад, ул. Кооперативная, д. 5', 'phones' => '(496) 540-22-48, (496) 540-22-49', 'email' => 'mircentr@yandex.ru', 'website' => null, 'description' => null, 'sort_order' => 1],
            ['title' => 'МБУ «Культурно-досуговый центр „Октябрь"»', 'leader' => 'директор — Мартынова Людмила Владимировна', 'address' => 'г. Сергиев Посад, пр. Красной Армии, д. 185', 'phones' => '(496) 540-24-04', 'email' => 'oktyabr-center@mail.ru', 'website' => null, 'description' => null, 'sort_order' => 2],
            ['title' => 'МБУ «Сергиево-Посадский музей-заповедник»', 'leader' => 'директор — Николаева Светлана Викторовна', 'address' => 'г. Сергиев Посад, пр. Красной Армии, д. 144', 'phones' => '(496) 540-53-56', 'email' => null, 'website' => 'https://museum-sp.ru', 'description' => null, 'sort_order' => 3],
            ['title' => 'МБУ «Центральная районная библиотека им. В.В. Розанова»', 'leader' => 'директор — Бирюкова Елена Владимировна', 'address' => 'г. Сергиев Посад, пр. Красной Армии, д. 192а', 'phones' => '(496) 540-44-55', 'email' => 'biblio.sergiev-posad@yandex.ru', 'website' => null, 'description' => null, 'sort_order' => 4],
            ['title' => 'МБУ ДО «Детская школа искусств № 1»', 'leader' => 'директор — Молчанова Ирина Николаевна', 'address' => 'г. Сергиев Посад, ул. Вознесенская, д. 55', 'phones' => '(496) 540-25-12', 'email' => 'spdsi1@mail.ru', 'website' => null, 'description' => null, 'sort_order' => 5],
        ];

        foreach ($rows as $row) {
            AdministrationInstitution::create($row);
        }
    }
}
