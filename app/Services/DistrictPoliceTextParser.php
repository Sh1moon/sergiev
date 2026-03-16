<?php

namespace App\Services;

class DistrictPoliceTextParser
{
    /**
     * Разбирает текст участковых на блоки по «Административный участок № N».
     * Поддерживает формат: блоки через двойной перенос строки (\n\n) или подряд в тексте.
     * Возвращает массив записей с ключами: admin_district, responsible, substitute, residential_sector, reception_days, leadership_reception_days, reception_place.
     */
    public static function parse(string $text): array
    {
        $text = preg_replace('/\r\n?/u', "\n", $text);
        $text = trim($text);
        $text = preg_replace('/^\xEF\xBB\xBF/u', '', $text); // BOM

        $result = self::splitIntoBlocksAndIntro($text);
        $intro = $result['intro'];
        $blocks = $result['blocks'];

        if (empty($blocks)) {
            return [];
        }

        $entries = [];
        foreach ($blocks as $i => $block) {
            $block = trim($block);
            if ($block === '' || mb_strpos($block, 'Ответственный:') === false) {
                continue;
            }

            $title = self::extractUntil($block, ['Ответственный:', 'Жилой сектор']);
            $title = trim(preg_replace('/\s+/u', ' ', $title));
            if ($i === 0 && $intro !== '') {
                $title = $intro . ' ' . $title;
            }

            $entries[] = [
                'admin_district' => $title ?: null,
                'responsible' => self::clean(self::extractBetween($block, 'Ответственный:', ['Замещает ответственного:'])),
                'substitute' => self::clean(self::extractBetween($block, 'Замещает ответственного:', ['Жилой сектор –', 'Жилой сектор'])),
                'residential_sector' => self::clean(self::extractBetween($block, ['Жилой сектор –', 'Жилой сектор'], ['Дни приема граждан:'])),
                'reception_days' => self::clean(self::extractBetween($block, 'Дни приема граждан:', ['Дни приема ответственного от руководства:'])),
                'leadership_reception_days' => self::clean(self::extractBetween($block, 'Дни приема ответственного от руководства:', ['Место приема граждан:', 'Место приёма граждан:'])),
                'reception_place' => self::clean(self::extractAfter($block, ['Место приема граждан:', 'Место приёма граждан:'])),
            ];
        }

        return $entries;
    }

    /** Разбивает текст на блоки. Первый абзац может содержать вступление + блок №1. Возвращает ['intro' => string, 'blocks' => array]. */
    private static function splitIntoBlocksAndIntro(string $text): array
    {
        $paragraphs = array_filter(explode("\n\n", $text), fn ($p) => trim($p) !== '');
        $paragraphs = array_values($paragraphs);

        $intro = '';
        $blocks = [];

        foreach ($paragraphs as $idx => $para) {
            $para = trim($para);
            $parts = preg_split('/(?=Административный участок №\s*\d+)/u', $para, -1, PREG_SPLIT_NO_EMPTY);

            if ($parts === false || count($parts) === 0) {
                if (trim($para) !== '' && mb_strpos($para, 'Ответственный:') !== false) {
                    $blocks[] = $para;
                }
                continue;
            }

            if (count($parts) === 1) {
                $blocks[] = $parts[0];
                continue;
            }

            $first = trim($parts[0]);
            $rest = array_slice($parts, 1);

            if ($idx === 0 && preg_match('/^Административный участок №\s*\d+/u', $first) !== 1 && mb_strpos($first, 'Ответственный:') === false) {
                $intro = $first;
            } else {
                $blocks[] = $first;
            }

            foreach ($rest as $p) {
                $p = trim($p);
                if ($p !== '') {
                    $blocks[] = $p;
                }
            }
        }

        if (empty($blocks)) {
            $chunks = preg_split('/(?=Административный участок №\s*\d+)/u', $text, -1, PREG_SPLIT_NO_EMPTY);
            if ($chunks !== false && count($chunks) >= 2) {
                $intro = trim($chunks[0]);
                $blocks = array_slice($chunks, 1);
            }
        }

        return ['intro' => $intro, 'blocks' => $blocks];
    }

    private static function extractUntil(string $haystack, array $stops): string
    {
        $pos = \strlen($haystack);
        foreach ($stops as $stop) {
            $p = mb_strpos($haystack, $stop);
            if ($p !== false && $p < $pos) {
                $pos = $p;
            }
        }
        return $pos === \strlen($haystack) ? $haystack : mb_substr($haystack, 0, $pos);
    }

    private static function extractBetween(string $haystack, string|array $start, array $ends): string
    {
        $startLabels = \is_array($start) ? $start : [$start];
        $startPos = null;
        $startLabelLen = 0;
        foreach ($startLabels as $s) {
            $p = mb_strpos($haystack, $s);
            if ($p !== false && ($startPos === null || $p < $startPos)) {
                $startPos = $p;
                $startLabelLen = mb_strlen($s);
            }
        }
        if ($startPos === null) {
            return '';
        }
        $contentStart = $startPos + $startLabelLen;
        $endPos = \strlen($haystack);
        foreach ($ends as $end) {
            $p = mb_strpos($haystack, $end, $contentStart);
            if ($p !== false && $p < $endPos) {
                $endPos = $p;
            }
        }
        return trim(mb_substr($haystack, $contentStart, $endPos - $contentStart));
    }

    private static function extractAfter(string $haystack, array $starts): string
    {
        $contentStart = null;
        foreach ($starts as $s) {
            $p = mb_strpos($haystack, $s);
            if ($p !== false) {
                $after = $p + mb_strlen($s);
                $contentStart = $contentStart === null ? $after : min($contentStart, $after);
            }
        }
        if ($contentStart === null) {
            return '';
        }
        $rest = mb_substr($haystack, $contentStart);
        $next = mb_strpos($rest, 'Административный участок №');
        if ($next !== false && $next > 0) {
            $rest = mb_substr($rest, 0, $next);
        }
        return trim($rest);
    }

    private static function clean(?string $s): ?string
    {
        if ($s === null || $s === '') {
            return null;
        }
        $s = trim($s);
        $s = preg_replace('/^\d+\s*$/um', '', $s);
        return $s === '' ? null : $s;
    }
}
