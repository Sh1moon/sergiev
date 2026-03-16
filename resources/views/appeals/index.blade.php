@extends('layouts.app')

@section('title', 'Обращения граждан')

@section('content')
<div class="appeals-page">
    <h1 class="appeals-title">Обращения граждан</h1>

    <p class="appeals-intro">Заполните форму ниже для отправки обращения. Все поля, отмеченные звёздочкой, обязательны для заполнения.</p>

    @include('appeals.partials.form')

    @if($myAppeals->isNotEmpty())
    <section class="my-appeals">
        <h2 class="my-appeals-title">Мои обращения</h2>
        <ul class="my-appeals-list">
            @foreach($myAppeals as $appeal)
            <li class="my-appeals-item">
                <div class="my-appeals-item-header">
                    <span class="my-appeals-date">{{ $appeal->created_at->format('d.m.Y H:i') }}</span>
                    @if($appeal->responded_at)
                        <span class="my-appeals-status my-appeals-status-answered">Ответ получен</span>
                    @else
                        <span class="my-appeals-status my-appeals-status-waiting">На рассмотрении</span>
                    @endif
                </div>
                <p class="my-appeals-excerpt">{{ Str::limit($appeal->body, 120) }}</p>
                <div class="my-appeals-item-actions">
                    <a href="{{ route('appeals.show', $appeal) }}" class="my-appeals-link">Просмотр</a>
                    @if(!$appeal->responded_at)
                        <a href="{{ route('appeals.edit', $appeal) }}" class="my-appeals-link">Редактировать</a>
                    @endif
                </div>
                @if($appeal->response)
                <div class="my-appeals-response">
                    <strong>Ответ:</strong>
                    <p>{{ nl2br(e($appeal->response)) }}</p>
                    <span class="my-appeals-response-date">{{ $appeal->responded_at->format('d.m.Y') }}</span>
                </div>
                @endif
            </li>
            @endforeach
        </ul>
    </section>
    @endif
</div>

<style>
.appeals-page { padding: 20px 0; max-width: 640px; }
.appeals-title { color: #1a3c1a; margin-bottom: 12px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; }
.appeals-intro { color: #555; margin-bottom: 24px; font-size: 1.2rem; line-height: 1.7; }
.appeals-form { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.required { color: #dc3545; }
.form-hint { font-size: 13px; color: #666; margin-top: 4px; display: block; }
.form-actions { margin-top: 24px; }

.form-group-consent { margin-top: 20px; }
.consent-label { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-weight: normal; }
.consent-checkbox { margin-top: 4px; flex-shrink: 0; width: 18px; height: 18px; }
.consent-text { display: inline; }
.consent-tooltip-wrap {
    display: inline-flex;
    align-items: center;
    position: relative;
    margin-left: 4px;
    vertical-align: middle;
}
.consent-tooltip-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #1a3c1a;
    color: #fafffa;
    font-size: 12px;
    font-weight: bold;
    cursor: help;
}
.consent-tooltip-content {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 100%;
    margin-bottom: 8px;
    width: 280px;
    padding: 12px;
    background: #1a3c1a;
    color: #fafffa;
    font-size: 12px;
    line-height: 1.4;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s ease;
    z-index: 100;
    pointer-events: none;
}
.consent-tooltip-content::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -6px;
    border: 6px solid transparent;
    border-top-color: #1a3c1a;
}
.consent-tooltip-wrap:hover .consent-tooltip-content,
.consent-tooltip-wrap:focus .consent-tooltip-content,
.consent-tooltip-wrap:focus-within .consent-tooltip-content {
    opacity: 1;
    visibility: visible;
}
.my-appeals { margin-top: 40px; padding-top: 24px; border-top: 1px solid #e8e8e8; }
.my-appeals-title { color: #1a3c1a; margin-bottom: 16px; font-size: 1.25rem; }
.my-appeals-list { list-style: none; padding: 0; margin: 0; }
.my-appeals-item { background: #fff; padding: 16px; border-radius: 8px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid #1a3c1a; }
.my-appeals-item-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; }
.my-appeals-item-actions { margin-top: 10px; display: flex; gap: 12px; flex-wrap: wrap; }
.my-appeals-link { color: #1a3c1a; font-weight: 500; }
.my-appeals-link:hover { color: #eac31b; }
.my-appeals-date { font-size: 14px; color: #666; }
.my-appeals-status { font-size: 13px; padding: 2px 8px; border-radius: 4px; }
.my-appeals-status-waiting { background: #fff3cd; color: #856404; }
.my-appeals-status-answered { background: #d4edda; color: #155724; }
.my-appeals-excerpt { color: #555; font-size: 1.2rem; line-height: 1.7; margin: 0 0 12px 0; }
.my-appeals-response { background: #f5f5f5; padding: 12px; border-radius: 6px; margin-top: 12px; }
.my-appeals-response strong { color: #1a3c1a; }
.my-appeals-response p { margin: 8px 0 0 0; color: #333; }
.my-appeals-response-date { font-size: 12px; color: #666; }
</style>
@endsection
