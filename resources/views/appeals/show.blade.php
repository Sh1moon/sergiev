@extends('layouts.app')

@section('title', 'Обращение #' . $appeal->id)

@section('content')
<div class="appeals-page appeals-show">
    <a href="{{ route('appeals') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку обращений</a>

    <div class="appeal-detail-card">
        <h1 class="appeal-detail-title">Обращение #{{ $appeal->id }}</h1>
        <div class="appeal-detail-meta">
            <span>{{ $appeal->created_at->format('d.m.Y H:i') }}</span>
            @if($appeal->responded_at)
                <span class="appeal-status appeal-status-answered">Ответ получен</span>
            @else
                <span class="appeal-status appeal-status-waiting">На рассмотрении</span>
            @endif
        </div>
        <dl class="appeal-detail-fields">
            <dt>ФИО</dt>
            <dd>{{ $appeal->fio }}</dd>
            <dt>Почтовый адрес</dt>
            <dd>{{ $appeal->postal_address ?: '—' }}</dd>
            <dt>Email</dt>
            <dd>{{ $appeal->email }}</dd>
            <dt>Телефон</dt>
            <dd>{{ $appeal->phone ?: '—' }}</dd>
            <dt>Текст обращения</dt>
            <dd class="appeal-detail-body">{{ nl2br(e($appeal->body)) }}</dd>
            @if($appeal->attachment)
            <dt>Прикреплённый файл</dt>
            <dd class="appeal-attachment">
                @if($appeal->isImageAttachment())
                    <div class="appeal-attachment-image-wrap">
                        <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener" class="appeal-attachment-open-tab">Открыть в новой вкладке</a>
                        <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener" class="js-img-lightbox appeal-attachment-thumb">
                            <img src="{{ route('appeals.attachment', $appeal) }}" alt="Приложение к обращению" class="appeal-attachment-img">
                        </a>
                    </div>
                @else
                    <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener" class="appeal-attachment-link">{{ $appeal->attachmentOriginalName() }}</a>
                    <span class="appeal-attachment-hint">(открывается в новой вкладке)</span>
                @endif
            </dd>
            @endif
        </dl>

        @if($appeal->response)
        <div class="appeal-detail-response">
            <h2 class="appeal-response-title">Ответ</h2>
            <p>{{ nl2br(e($appeal->response)) }}</p>
            <div class="appeal-detail-response-meta">{{ $appeal->responded_at->format('d.m.Y H:i') }}</div>
        </div>
        @endif

        @if(!$appeal->responded_at)
        <p class="appeal-actions">
            <a href="{{ route('appeals.edit', $appeal) }}" class="btn btn-primary">Редактировать обращение</a>
        </p>
        @endif
    </div>
</div>

<style>
.appeals-show { padding: 20px 0; max-width: 720px; }
.appeal-detail-card { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.appeal-detail-title { color: #1a3c1a; margin-bottom: 12px; border-bottom: 2px solid #1a3c1a; padding-bottom: 10px; font-size: 1.5rem; }
.appeal-detail-meta { font-size: 14px; color: #666; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
.appeal-status { font-size: 13px; padding: 2px 8px; border-radius: 4px; }
.appeal-status-waiting { background: #fff3cd; color: #856404; }
.appeal-status-answered { background: #d4edda; color: #155724; }
.appeal-detail-fields { margin: 0; }
.appeal-detail-fields dt { font-weight: 600; color: #1a3c1a; margin-top: 16px; margin-bottom: 4px; }
.appeal-detail-fields dd { margin: 0; color: #333; }
.appeal-detail-body { white-space: pre-wrap; line-height: 1.7; }
.appeal-attachment { margin-top: 8px; }
.appeal-attachment-image-wrap { margin-top: 8px; }
.appeal-attachment-open-tab { display: inline-block; margin-bottom: 8px; font-size: 14px; color: #1a3c1a; }
.appeal-attachment-open-tab:hover { color: #eac31b; }
.appeal-attachment-thumb { display: inline-block; max-width: 100%; }
.appeal-attachment-img { max-width: 320px; max-height: 240px; object-fit: contain; border-radius: 6px; border: 1px solid #e8e8e8; cursor: pointer; }
.appeal-attachment-img:hover { opacity: 0.9; }
.appeal-attachment-link { color: #1a3c1a; font-weight: 500; }
.appeal-attachment-link:hover { color: #eac31b; }
.appeal-attachment-hint { font-size: 13px; color: #666; margin-left: 6px; }
.appeal-detail-response { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; background: #f9f9f9; padding: 16px; border-radius: 6px; }
.appeal-response-title { color: #1a3c1a; margin-bottom: 10px; font-size: 1.2rem; }
.appeal-detail-response-meta { font-size: 13px; color: #666; margin-top: 10px; }
.appeal-actions { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; }
</style>
@endsection
