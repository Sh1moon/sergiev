@extends('layouts.app')

@section('title', 'АНК')

@section('content')
<div class="appeals-ank-page">
    <h1 class="page-title">АНТИНАРКОТИЧЕСКАЯ КОМИССИЯ СЕРГИЕВО-ПОСАДСКОГО ГОРОДСКОГО ОКРУГА</h1>

    <div class="appeals-ank-content">
        <p>Приём граждан по вопросам исполнения законодательства Российской Федерации о наркотических средствах, психотропных веществах и их прекурсорах осуществляется в приёмной заместителя председателя антинаркотической комиссии Сергиево-Посадского городского округа каждый третий четверг месяца с 15:00 до 17:00.</p>

        <p><strong>Адрес:</strong> проспект Красной Армии, д.169, г. Сергиев Посад, Московская область, 141301, кабинет № 302</p>

        <p><strong>Телефон для записи на прием:</strong> +7 496 551 50 77</p>

        <p><strong>Страница для обращения граждан:</strong> <a href="{{ route('appeals') }}">перейти в раздел «Обращения граждан»</a></p>

        <p><strong>Электронная почта для обращений и записи на прием:</strong> <a href="mailto:5429684@mail.ru">5429684@mail.ru</a></p>
    </div>
</div>

<style>
.appeals-ank-page { padding: 20px 0; max-width: 800px; }
.appeals-ank-page .page-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 12px; font-size: 1.25rem; line-height: 1.4; }
.appeals-ank-content { color: #333; line-height: 1.7; }
.appeals-ank-content p { margin-bottom: 1em; }
.appeals-ank-content a { color: #1a3c1a; text-decoration: underline; }
.appeals-ank-content a:hover { color: #2a5a2a; }
</style>
@endsection
