<?php

namespace Database\Seeders;

use App\Models\AdministrationTerritory;
use Illuminate\Database\Seeder;

class AdministrationTerritoriesSeeder extends Seeder
{
    public function run(): void
    {
        if (AdministrationTerritory::exists()) {
            return;
        }

        $rows = [
            ['management' => 'Территориальное управление «Сергиев Посад»', 'leader' => 'Агафонов Алексей Викторович', 'contacts' => "(496) 551-51-00\ntusergposad@mosreg.ru", 'address' => 'г. Сергиев Посад, пр. Красной Армии, д. 203в', 'sort_order' => 1],
            ['management' => 'Территориальное управление «Хотьково»', 'leader' => 'Смирнов Сергей Николаевич', 'contacts' => "(496) 543-02-35\ntukhotkovo@mosreg.ru", 'address' => 'г. Хотьково, ул. Московская, д. 38', 'sort_order' => 2],
            ['management' => 'Территориальное управление «Краснозаводск»', 'leader' => 'Козлов Андрей Игоревич', 'contacts' => "(496) 545-11-22\ntukrasnozavodsk@mosreg.ru", 'address' => 'г. Краснозаводск, ул. Труда, д. 12', 'sort_order' => 3],
            ['management' => 'Территориальное управление «Пересвет»', 'leader' => 'Павлов Дмитрий Сергеевич', 'contacts' => "(496) 546-15-18\ntuperesvet@mosreg.ru", 'address' => 'г. Пересвет, ул. Мира, д. 8', 'sort_order' => 4],
        ];

        foreach ($rows as $row) {
            AdministrationTerritory::create($row);
        }
    }
}
