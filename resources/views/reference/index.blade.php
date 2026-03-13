@extends('layouts.app')

@section('title', 'Справочная')

@section('content')
<div class="reference-page">
    <h1 class="reference-page-title">Справочная</h1>

    <section class="reference-section" id="district-police">
        <h2 class="reference-section-title">Отдел участковых по району</h2>
        <div class="reference-section-body reference-district-police">
            @foreach(array_filter(explode("\n\n", $districtPoliceContent)) as $paragraph)
                {!! \App\Http\Controllers\ReferenceController::formatDistrictPoliceParagraph($paragraph) !!}
            @endforeach
        </div>
    </section>

    <section class="reference-section" id="emergency">
        <h2 class="reference-section-title">Телефоны экстренных служб</h2>
        <div class="reference-section-body reference-emergency">
            @if(trim($emergencyContent ?? '') !== '')
                @foreach(array_filter(explode("\n\n", $emergencyContent)) as $block)
                    @php
                        $trimmed = trim($block);
                        $singleLine = !str_contains($trimmed, "\n") && $trimmed !== '';
                        $hasDash = $singleLine && preg_match('/ — /u', $trimmed);
                    @endphp
                    <p class="{{ $hasDash ? 'ref-emergency-heading' : 'ref-emergency-block' }}">{!! \App\Http\Controllers\ReferenceController::formatEmergencyBlock($block) !!}</p>
                @endforeach
            @else
                <p class="reference-placeholder">Раздел в разработке. Содержимое будет добавлено позже.</p>
            @endif
        </div>
    </section>

   

    <section class="reference-section" id="management-companies">
        <h2 class="reference-section-title">Управляющие компании</h2>
        <div class="reference-section-body">
            @if(!empty($managementTables['managing']) || !empty($managementTables['resource']))
                <div class="reference-management-tables">
                    @if(!empty($managementTables['managing']))
                        <h3 class="ref-management-subtitle">Управляющие организации Сергиево-Посадского г.о.</h3>
                        <div class="table-responsive">
                            <table class="honorary-table ref-management-table">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Название организации, адрес, руководитель, телефон, эл.почта</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($managementTables['managing'] as $row)
                                        <tr>
                                            <td>{{ $row['num'] }}</td>
                                            <td>{!! $row['content'] !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    @if(!empty($managementTables['resource']))
                        <h3 class="ref-management-subtitle">Ресурсоснабжающие организации</h3>
                        <div class="table-responsive">
                            <table class="honorary-table ref-management-table">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Организация, руководитель, адрес, телефон, эл.почта</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($managementTables['resource'] as $row)
                                        <tr>
                                            <td>{{ $row['num'] }}</td>
                                            <td>{!! $row['content'] !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @else
                <p class="reference-placeholder">Раздел в разработке. Содержимое будет добавлено позже.</p>
            @endif
        </div>
    </section>

    <section class="reference-section" id="vacancies">
        <h2 class="reference-section-title">Вакансии</h2>
        <div class="reference-section-body reference-vacancies">
            @if(trim($vacanciesIntro ?? '') !== '')
                <div class="ref-vacancies-intro">
                    @foreach(array_filter(explode("\n\n", $vacanciesIntro)) as $p)
                        <p>{{ $p }}</p>
                    @endforeach
                </div>
            @endif
            @if(isset($vacancies) && $vacancies->isNotEmpty())
                <h3 class="ref-vacancies-list-title">Актуальные вакансии</h3>
                <ul class="ref-vacancies-list">
                    @foreach($vacancies as $vacancy)
                        <li>
                            <a href="{{ route('vacancy.show', $vacancy->slug) }}" class="ref-vacancies-link">
                                <span class="ref-vacancies-date">{{ $vacancy->published_at?->format('d.m.Y') }}</span>
                                {{ $vacancy->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
</div>

<style>
.reference-page { padding: 20px 0 60px; max-width: 920px; }
.reference-page-title { color: #1a3c1a; font-size: 1.75rem; margin-bottom: 32px; border-bottom: 2px solid #1a3c1a; padding-bottom: 12px; }
.reference-section { margin-bottom: 48px; scroll-margin-top: 100px; }
.reference-section-title { color: #1a3c1a; font-size: 1.35rem; margin-bottom: 20px; padding-bottom: 8px; border-bottom: 1px solid #d0e0d0; }
.reference-section-body { font-size: 0.95rem; line-height: 1.7; color: #333; }
.reference-placeholder { color: #666; font-style: italic; }

.reference-district-police { }
.reference-district-police .ref-block-text { margin-bottom: 14px; }
.reference-district-police .ref-block-text:last-child { margin-bottom: 0; }
.reference-district-police .ref-block-title { font-weight: 700; color: #1a3c1a; margin: 22px 0 10px 0; font-size: 1.02rem; line-height: 1.6; padding-left: 0; }
.reference-district-police .ref-block-title:first-of-type { margin-top: 0; }
.reference-district-police .ref-department-title { font-weight: 700; color: #0f2d0f; margin: 28px 0 12px 0; font-size: 1.1rem; line-height: 1.5; border-bottom: 1px solid #c5e0c5; padding-bottom: 6px; }
.reference-district-police .ref-department-title:first-of-type { margin-top: 0; }

.reference-district-police .ref-responsible-block { background: #f4f9f4; border-left: 4px solid #1a3c1a; padding: 12px 16px; margin: 12px 0 16px 0; border-radius: 0 6px 6px 0; }
.reference-district-police .ref-responsible-line { margin: 0 0 8px 0; line-height: 1.5; }
.reference-district-police .ref-responsible-line:last-child { margin-bottom: 0; }
.reference-district-police .ref-responsible-label { font-weight: 700; color: #1a3c1a; }
.reference-district-police .ref-sector-label { font-weight: 700; color: #1a3c1a; }

.reference-emergency .ref-emergency-name { font-weight: 700; color: #1a3c1a; }
.reference-emergency .ref-emergency-heading { font-weight: 600; color: #1a3c1a; margin-bottom: 8px; }
.reference-emergency .ref-emergency-block { margin-bottom: 14px; line-height: 1.6; }
.reference-emergency .ref-emergency-block:last-child { margin-bottom: 0; }
.reference-emergency a { color: #1a5c1a; text-decoration: underline; }
.reference-emergency a:hover { color: #eac31b; }

.reference-management-tables { }
.ref-management-subtitle { color: #1a3c1a; font-size: 1.15rem; margin: 24px 0 16px 0; }
.ref-management-subtitle:first-child { margin-top: 0; }
.reference-section .table-responsive { overflow-x: auto; margin-bottom: 20px; }
.reference-section .honorary-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
    background: #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    border-radius: 8px;
    overflow: hidden;
}
.reference-section .honorary-table th,
.reference-section .honorary-table td { padding: 12px 16px; text-align: left; border-bottom: 1px solid #eee; }
.reference-section .honorary-table th { background: #1a3c1a; color: #fafffa; font-weight: 600; }
.reference-section .honorary-table tbody tr:hover { background: #f9f9f9; }
.reference-section .honorary-table td:first-child { font-weight: 500; color: #1a3c1a; width: 50px; vertical-align: top; }
.reference-section .honorary-table td a { color: #1a5c1a; text-decoration: underline; }
.reference-section .honorary-table td a:hover { color: #eac31b; }

.ref-vacancies-intro { margin-bottom: 24px; }
.ref-vacancies-intro p { margin-bottom: 12px; line-height: 1.65; }
.ref-vacancies-list-title { color: #1a3c1a; font-size: 1.1rem; margin: 20px 0 12px 0; }
.ref-vacancies-list { list-style: none; padding: 0; margin: 0; }
.ref-vacancies-list li { margin-bottom: 10px; }
.ref-vacancies-link { display: inline-flex; align-items: baseline; gap: 12px; text-decoration: none; color: #1a3c1a; }
.ref-vacancies-link:hover { color: #eac31b; }
.ref-vacancies-date { font-size: 0.9em; color: #666; flex-shrink: 0; }
</style>
@endsection
