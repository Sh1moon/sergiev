<?php

namespace Database\Seeders;

use App\Models\DistrictPoliceEntry;
use App\Services\DistrictPoliceTextParser;
use Illuminate\Database\Seeder;

class DistrictPoliceEntriesSeeder extends Seeder
{
    public function run(): void
    {
        $path = resource_path('data/district_police.txt');
        if (!is_file($path)) {
            $path = database_path('seeders/data/district_police_raw.txt');
        }
        if (!is_file($path)) {
            $this->command?->warn('Файл с текстом участковых не найден. Используйте resources/data/district_police.txt или database/seeders/data/district_police_raw.txt');
            return;
        }

        $text = file_get_contents($path);
        $entries = DistrictPoliceTextParser::parse($text);
        if (empty($entries)) {
            $this->command?->warn('Не удалось разобрать записи из файла.');
            return;
        }

        DistrictPoliceEntry::truncate();

        foreach ($entries as $index => $data) {
            DistrictPoliceEntry::create([
                'sort_order' => $index + 1,
                'admin_district' => $data['admin_district'] ?? null,
                'responsible' => $data['responsible'] ?? null,
                'substitute' => $data['substitute'] ?? null,
                'residential_sector' => $data['residential_sector'] ?? null,
                'reception_days' => $data['reception_days'] ?? null,
                'leadership_reception_days' => $data['leadership_reception_days'] ?? null,
                'reception_place' => $data['reception_place'] ?? null,
            ]);
        }

        $this->command?->info('Добавлено записей участковых: ' . count($entries));
    }
}
