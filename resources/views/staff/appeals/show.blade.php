@extends('layouts.app')

@section('title', 'Обращение #' . $appeal->id)

@section('content')
<div class="staff-appeal-detail">
    <a href="{{ route('staff.appeals.index') }}?filter={{ $appeal->responded_at ? 'archived' : 'new' }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <div class="appeal-detail-card">
        <h2>Обращение #{{ $appeal->id }}</h2>
        <div class="appeal-detail-meta">
            <span>{{ $appeal->created_at->format('d.m.Y H:i') }}</span>
            @if($appeal->user)
                <span>Пользователь: {{ $appeal->user->name }} ({{ $appeal->user->email }})</span>
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
            <dt>Файл</dt>
            <dd><a href="{{ Storage::url($appeal->attachment) }}" target="_blank" rel="noopener">Скачать</a></dd>
            @endif
        </dl>

        @if($appeal->response)
        <div class="appeal-detail-response">
            <h3>Ответ</h3>
            <p>{{ nl2br(e($appeal->response)) }}</p>
            <div class="appeal-detail-response-meta">
                {{ $appeal->responded_at->format('d.m.Y H:i') }}
                @if($appeal->responder)
                    — {{ $appeal->responder->name }}
                @endif
            </div>
        </div>
        @else
        <form action="{{ route('staff.appeals.respond', $appeal) }}" method="POST" class="appeal-respond-form">
            @csrf
            <div class="form-group">
                <label for="response" class="form-label">Текст ответа <span class="required">*</span></label>
                <textarea name="response" id="response" class="form-control @error('response') is-invalid @enderror" rows="6" required>{{ old('response') }}</textarea>
                @error('response')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Отправить ответ</button>
        </form>
        @endif
    </div>
</div>

<style>
.staff-appeal-detail { padding: 20px 0; max-width: 720px; }
.appeal-detail-card { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.appeal-detail-card h2 { color: #1a3c1a; margin-bottom: 12px; }
.appeal-detail-meta { font-size: 14px; color: #666; margin-bottom: 20px; }
.appeal-detail-fields { margin: 0; }
.appeal-detail-fields dt { font-weight: 600; color: #1a3c1a; margin-top: 12px; margin-bottom: 4px; }
.appeal-detail-fields dd { margin: 0; color: #333; }
.appeal-detail-body { white-space: pre-wrap; }
.appeal-detail-response { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; background: #f9f9f9; padding: 16px; border-radius: 6px; }
.appeal-detail-response h3 { color: #1a3c1a; margin-bottom: 10px; font-size: 1.1rem; }
.appeal-detail-response-meta { font-size: 13px; color: #666; margin-top: 10px; }
.appeal-respond-form { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; }
.required { color: #dc3545; }
</style>
@endsection
