@extends('layouts.app')

@section('title', 'Совет депутатов')

@section('content')
<div class="council-deputies-page">
    <h1 class="page-title">Совет депутатов</h1>

    <div class="deputies-list">
        @forelse($deputies ?? [] as $deputy)
        <div class="deputy-card">
            @if($deputy->photoUrl())
            <div class="deputy-photo-wrap">
                <img src="{{ $deputy->photoUrl() }}" alt="{{ $deputy->name }}" class="deputy-photo">
            </div>
            @endif
            <div class="deputy-name">{{ $deputy->name }}</div>
            @if($deputy->info)<div class="deputy-info">{{ $deputy->info }}</div>@endif
            @if($deputy->contacts)<div class="deputy-contacts">{!! nl2br(e($deputy->contacts)) !!}</div>@endif
        </div>
        @empty
        <p>Список депутатов пока не заполнен.</p>
        @endforelse
    </div>

    <section class="council-disclosure">
        <h2>Сведения о доходах, расходах, об имуществе и обязательствах имущественного характера</h2>
        <p>Лицами, замещающими муниципальные должности в Совете депутатов Сергиево-Посадского городского округа и членов их семьи за период с 01.01.2022 г. по 31.12.2022 г.</p>
        <p>Обязанность по предоставлению сведений о доходах, расходах, об имуществе и обязательствах имущественного характера всеми депутатами Совета депутатов Сергиево-Посадского городского округа исполнена в полном объеме в сроки, предусмотренные законодательством Российской Федерации.</p>
        <p>В соответствии с подпунктом «ж» пункта 1 Указа Президента РФ от 29.12.2022 № 968 «Об особенностях исполнения обязанностей, соблюдения ограничений и запретов в области противодействия коррупции некоторыми категориями граждан в период проведения специальной военной операции» в период проведения СВО и впредь до издания соответствующих нормативных правовых актов Российской Федерации размещение сведений на официальных сайтах органов публичной власти и организаций в сети «Интернет» и их предоставление общероссийским СМИ для опубликования не осуществляются. (<a href="http://pravo.gov.ru/proxy/ips/?docbody=&link_id=0&nd=603637722" target="_blank" rel="noopener">pravo.gov.ru</a>)</p>
    </section>
</div>

<style>
.council-deputies-page { padding: 20px 0; max-width: 900px; }
.council-deputies-page .page-title { color: #1a3c1a; margin-bottom: 24px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.deputy-card { background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-bottom: 20px; padding: 20px; border-left: 4px solid #1a3c1a; display: flex; flex-wrap: wrap; gap: 20px; }
.deputy-photo-wrap { flex-shrink: 0; }
.deputy-photo { width: 120px; height: 150px; object-fit: cover; border-radius: 6px; }
.deputy-name { font-size: 1.2rem; font-weight: 600; color: #1a3c1a; margin-bottom: 8px; }
.deputy-info { font-size: 14px; color: #555; line-height: 1.6; margin-bottom: 8px; }
.deputy-contacts { font-size: 14px; margin-top: 12px; }
.deputy-contacts a { color: #1a3c1a; text-decoration: none; }
.deputy-contacts a:hover { color: #eac31b; text-decoration: underline; }
.deputy-contacts .contact-item { display: block; margin-bottom: 6px; }
.council-disclosure { margin-top: 48px; padding-top: 24px; border-top: 1px solid #e8e8e8; }
.council-disclosure h2 { color: #1a3c1a; font-size: 1.15rem; margin-bottom: 16px; }
.council-disclosure p { color: #333; line-height: 1.7; margin-bottom: 1em; }
</style>
@endsection
