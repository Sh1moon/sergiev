@extends('layouts.app')

@section('title', 'Сообщение #' . $report->id)

@section('content')
<div class="staff-report-detail">
    <a href="{{ route('staff.anticorruption.index') }}?filter={{ $report->responded_at ? 'archived' : 'new' }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <div class="report-detail-card">
        <h2>Сообщение #{{ $report->id }}</h2>
        <div class="report-detail-meta">
            <span>{{ $report->created_at->format('d.m.Y H:i') }}</span>
            @if($report->user)
                <span>Пользователь: {{ $report->user->name }} ({{ $report->user->email }})</span>
            @endif
        </div>
        <dl class="report-detail-fields">
            <dt>E-mail для ответа</dt>
            <dd>{{ $report->email }}</dd>
            <dt>Текст сообщения</dt>
            <dd class="report-detail-body">{{ nl2br(e($report->body)) }}</dd>
        </dl>

        @if($report->response)
        <div class="report-detail-response">
            <h3>Ответ</h3>
            <p>{{ nl2br(e($report->response)) }}</p>
            <div class="report-detail-response-meta">
                {{ $report->responded_at->format('d.m.Y H:i') }}
                @if($report->responder)
                    — {{ $report->responder->name }}
                @endif
            </div>
        </div>
        @else
        <form action="{{ route('staff.anticorruption.respond', $report) }}" method="POST" class="report-respond-form">
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
.staff-report-detail { padding: 20px 0; max-width: 720px; }
.report-detail-card { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.report-detail-card h2 { color: #1a3c1a; margin-bottom: 12px; }
.report-detail-meta { font-size: 14px; color: #666; margin-bottom: 20px; }
.report-detail-fields { margin: 0; }
.report-detail-fields dt { font-weight: 600; color: #1a3c1a; margin-top: 12px; margin-bottom: 4px; }
.report-detail-fields dd { margin: 0; color: #333; }
.report-detail-body { white-space: pre-wrap; }
.report-detail-response { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; background: #f9f9f9; padding: 16px; border-radius: 6px; }
.report-detail-response h3 { color: #1a3c1a; margin-bottom: 10px; font-size: 1.1rem; }
.report-detail-response-meta { font-size: 13px; color: #666; margin-top: 10px; }
.report-respond-form { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; }
.required { color: #dc3545; }
</style>
@endsection
