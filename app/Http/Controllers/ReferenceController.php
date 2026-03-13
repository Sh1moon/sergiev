<?php

namespace App\Http\Controllers;

use App\Models\Vacancy;
use App\Models\ReferenceSection;
use App\Models\ManagementCompanyRow;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ReferenceController extends Controller
{
    public function index()
    {
        $districtPoliceSection = ReferenceSection::where('slug', 'district_police')->first();
        $emergencySection = ReferenceSection::where('slug', 'emergency_phones')->first();
        $districtPoliceContent = $districtPoliceSection?->content ?? (File::exists(resource_path('data/district_police.txt'))
            ? File::get(resource_path('data/district_police.txt')) : '');
        $emergencyContent = $emergencySection?->content ?? (File::exists(resource_path('data/emergency_phones.txt'))
            ? File::get(resource_path('data/emergency_phones.txt')) : '');

        $managingRows = ManagementCompanyRow::where('section', 'managing')->orderBy('sort_order')->orderBy('num')->get();
        $resourceRows = ManagementCompanyRow::where('section', 'resource')->orderBy('sort_order')->orderBy('num')->get();
        if ($managingRows->isEmpty() && $resourceRows->isEmpty()) {
            $managementCompaniesContent = File::exists(resource_path('data/management_companies.txt'))
                ? File::get(resource_path('data/management_companies.txt')) : '';
            $managementTables = $managementCompaniesContent !== ''
                ? self::parseManagementCompaniesTables($managementCompaniesContent)
                : ['managing' => [], 'resource' => []];
        } else {
            $linkify = function (string $s): string {
                $s = e($s);
                $s = preg_replace_callback(
                    '/(https?:\/\/[^\s<>"\']+)/u',
                    fn ($m) => '<a href="' . $m[1] . '" target="_blank" rel="noopener noreferrer">' . $m[1] . '</a>',
                    $s
                );
                $s = preg_replace_callback(
                    '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/u',
                    fn ($m) => '<a href="mailto:' . $m[1] . '">' . $m[1] . '</a>',
                    $s
                );
                return nl2br($s);
            };
            $managementTables = [
                'managing' => $managingRows->map(fn ($r) => ['num' => $r->num, 'content' => $linkify($r->content)])->all(),
                'resource' => $resourceRows->map(fn ($r) => ['num' => $r->num, 'content' => $linkify($r->content)])->all(),
            ];
        }
        $vacanciesIntro = File::exists(resource_path('data/vacancies_intro.txt'))
            ? File::get(resource_path('data/vacancies_intro.txt')) : '';
        $vacancies = Vacancy::published()->orderByDesc('published_at')->get();

        return view('reference.index', [
            'districtPoliceContent' => $districtPoliceContent,
            'emergencyContent' => $emergencyContent,
            'managementTables' => $managementTables,
            'vacanciesIntro' => $vacanciesIntro,
            'vacancies' => $vacancies,
        ]);
    }

    /**
     * Форматирует абзац раздела «Участковые»: блок Ответственный/Замещает, выделение Жилой сектор.
     */
    public static function formatDistrictPoliceParagraph(string $paragraph): string
    {
        $t = trim($paragraph);
        $e = fn ($s) => e($s);

        if (Str::startsWith($t, 'Отдел полиции г.')) {
            return '<p class="ref-department-title">' . $e($paragraph) . '</p>';
        }
        $blockStart = mb_strpos($t, 'Административный участок №');
        if ($blockStart !== false && ($blockStart === 0 || $blockStart > 0)) {
            $blockPart = $blockStart === 0 ? $t : trim(mb_substr($t, $blockStart));
            $introPart = $blockStart === 0 ? '' : trim(mb_substr($t, 0, $blockStart));
            if ($introPart !== '' && Str::contains($blockPart, 'Ответственный:') && Str::contains($blockPart, 'Замещает ответственного:')) {
                $introSafe = $e($introPart);
                $introSafe = str_replace('Жилой сектор', '<strong class="ref-sector-label">Жилой сектор</strong>', $introSafe);
                $formattedBlock = self::formatBlockWithResponsible($blockPart, $e);
                return '<p class="ref-block-text">' . $introSafe . '</p>' . $formattedBlock;
            }
        }

        if (Str::startsWith($t, 'Административный участок №')) {
            if (Str::contains($t, 'Ответственный:') && Str::contains($t, 'Замещает ответственного:')) {
                return self::formatBlockWithResponsible($t, $e);
            }
            return '<p class="ref-block-title">' . $e($paragraph) . '</p>';
        }

        $safe = $e($paragraph);
        $safe = str_replace('Жилой сектор', '<strong class="ref-sector-label">Жилой сектор</strong>', $safe);
        return '<p class="ref-block-text">' . $safe . '</p>';
    }

    private static function formatBlockWithResponsible(string $t, callable $e): string
    {
        $idxResp = mb_strpos($t, 'Ответственный:');
        $afterResp = mb_substr($t, $idxResp);
        $idxZamIn = mb_strpos($afterResp, 'Замещает ответственного:');
        $title = trim(mb_substr($t, 0, $idxResp));
        $respFull = trim(mb_substr($afterResp, 0, $idxZamIn));
        $respValue = trim(mb_substr($respFull, mb_strlen('Ответственный:')));
        if (Str::endsWith($respValue, '.')) {
            $respValue = mb_substr($respValue, 0, -1);
        }
        $afterZam = trim(mb_substr($afterResp, $idxZamIn));
        $zamLabelLen = mb_strlen('Замещает ответственного:');
        $zamRest = trim(mb_substr($afterZam, $zamLabelLen));
        $dotZh = mb_strpos($zamRest, '. Жилой сектор');
        if ($dotZh !== false) {
            $zamValue = trim(mb_substr($zamRest, 0, $dotZh));
            if (Str::endsWith($zamValue, '.')) {
                $zamValue = mb_substr($zamValue, 0, -1);
            }
            $rest = trim(mb_substr($zamRest, $dotZh + 2));
        } else {
            $zamValue = $zamRest;
            $rest = '';
        }
        $restHtml = $rest !== '' ? str_replace('Жилой сектор', '<strong class="ref-sector-label">Жилой сектор</strong>', $e($rest)) : '';
        return '<p class="ref-block-title">' . $e($title) . '</p>'
            . '<div class="ref-responsible-block">'
            . '<p class="ref-responsible-line"><span class="ref-responsible-label">Ответственный:</span> ' . $e($respValue) . '</p>'
            . '<p class="ref-responsible-line"><span class="ref-responsible-label">Замещает ответственного:</span> ' . $e($zamValue) . '</p>'
            . '</div>'
            . ($restHtml !== '' ? '<p class="ref-block-text">' . $restHtml . '</p>' : '');
    }

    /**
     * Форматирует блок раздела «Телефоны экстренных служб»: выделение названий служб, кликабельные ссылки и email.
     */
    public static function formatEmergencyBlock(string $block): string
    {
        $safe = e(trim($block));
        if ($safe === '') {
            return '';
        }
        $nameOnlyLines = [
            'Сергиево-Посадский филиал АО «Мособлэнерго»',
            'Сергиево-Посадский РЭС филиала ПАО «МОЭСК»',
            'Диспетчерская служба',
            'Единый контактный центр',
            'Эксплуатирующая организация Сергиево-Посадского городского округа ООО «НОРЭНЕРГО»',
            'Территориальный отдел № 4 Госадмтехнадзора Московской области',
        ];
        $lines = explode("\n", $safe);
        foreach ($lines as $i => $line) {
            $trimmed = trim($line);
            if ($trimmed === '') {
                continue;
            }
            if (Str::contains($line, ' — ')) {
                $parts = explode(' — ', $line, 2);
                $name = trim($parts[0]);
                $rest = trim($parts[1] ?? '');
                $lines[$i] = '<span class="ref-emergency-name">' . $name . '</span> — ' . $rest;
            } else {
                foreach ($nameOnlyLines as $nameLine) {
                    if ($trimmed === $nameLine || Str::startsWith($trimmed, $nameLine . ' ') || Str::startsWith($trimmed, $nameLine . ' (')) {
                        $lines[$i] = '<span class="ref-emergency-name">' . $trimmed . '</span>';
                        break;
                    }
                }
            }
        }
        $safe = implode("\n", $lines);
        $safe = preg_replace_callback(
            '/(https?:\/\/[^\s<>"\']+)/u',
            fn ($m) => '<a href="' . $m[1] . '" target="_blank" rel="noopener noreferrer">' . $m[1] . '</a>',
            $safe
        );
        $safe = preg_replace_callback(
            '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/u',
            fn ($m) => '<a href="mailto:' . $m[1] . '">' . $m[1] . '</a>',
            $safe
        );
        return nl2br($safe);
    }

    /**
     * Парсит текст управляющих компаний в две таблицы (управляющие и ресурсоснабжающие).
     * Возвращает ['managing' => [[num, content], ...], 'resource' => [[num, content], ...]]
     */
    public static function parseManagementCompaniesTables(string $content): array
    {
        $linkify = function (string $s): string {
            $s = e($s);
            $s = preg_replace_callback(
                '/(https?:\/\/[^\s<>"\']+)/u',
                fn ($m) => '<a href="' . $m[1] . '" target="_blank" rel="noopener noreferrer">' . $m[1] . '</a>',
                $s
            );
            $s = preg_replace_callback(
                '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})/u',
                fn ($m) => '<a href="mailto:' . $m[1] . '">' . $m[1] . '</a>',
                $s
            );
            return nl2br($s);
        };

        $rows = function (string $part) use ($linkify): array {
            // Делим только по номерам строк (1–2 цифры), не по телефонам вроде 89165780721 или 5510660
            $blocks = preg_split('/\n(?=\d{1,2}\n)/u', $part, -1, PREG_SPLIT_NO_EMPTY);
            $result = [];
            foreach ($blocks as $block) {
                $lines = explode("\n", trim($block));
                if ($lines === [] || !ctype_digit(trim($lines[0]))) {
                    continue;
                }
                $num = trim($lines[0]);
                $rest = implode("\n", array_slice($lines, 1));
                $result[] = ['num' => $num, 'content' => $linkify($rest)];
            }
            return $result;
        };

        $content = trim($content);
        $parts = preg_split('/\nРесурсоснабжающие организации\n/u', $content, 2);
        $managingRaw = isset($parts[0]) ? $parts[0] : '';
        $resourceRaw = isset($parts[1]) ? $parts[1] : '';
        $managingRaw = preg_replace('/^.*?(?=\n1\n)/us', '', $managingRaw);
        $managing = $rows($managingRaw);
        $resource = $rows($resourceRaw);

        return ['managing' => $managing, 'resource' => $resource];
    }

    /**
     * Редирект со старых URL на якорь на единой странице.
     */
    public function redirectToSection(string $section)
    {
        $allowed = ['district-police', 'emergency', 'departments', 'sitemap', 'management-companies', 'vacancies'];
        if (!in_array($section, $allowed, true)) {
            return redirect()->route('reference');
        }
        return redirect()->route('reference', [], 301)->withFragment($section);
    }
}
