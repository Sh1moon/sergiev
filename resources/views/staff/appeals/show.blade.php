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
            <dt>Категория проблемы</dt>
            <dd>{{ $appeal->problemCategory?->name ?: '—' }}</dd>
            <dt>Подкатегория</dt>
            <dd>{{ $appeal->problemSubcategory?->name ?: '—' }}</dd>
            <dt>Детальная проблема</dt>
            <dd>{{ $appeal->problemDetail?->name ?: '—' }}</dd>
            <dt>Текст обращения</dt>
            <dd class="appeal-detail-body">{{ nl2br(e($appeal->body)) }}</dd>
            @if($appeal->attachment)
            <dt>Файл</dt>
            <dd class="appeal-attachment">
                @if($appeal->isImageAttachment())
                    <div class="appeal-attachment-image-wrap">
                        <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener" class="appeal-attachment-open-tab">Открыть в новой вкладке</a>
                        <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener" class="js-img-lightbox appeal-attachment-thumb">
                            <img src="{{ route('appeals.attachment', $appeal) }}" alt="Вложение к обращению" class="appeal-attachment-img">
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
            <h3>Ответ</h3>
            <div class="appeal-response-text">{!! $appeal->response !!}</div>
            @if($appeal->responsePhotos->isNotEmpty())
                <div class="appeal-response-photos">
                    <p class="appeal-response-photos-title">Фотоотчёт:</p>
                    <div class="appeal-response-photos-grid">
                        @foreach($appeal->responsePhotos as $photo)
                            <a href="{{ route('appeals.response-photo', ['appeal' => $appeal, 'photoId' => $photo->id]) }}" target="_blank" rel="noopener" class="js-img-lightbox appeal-response-photo-link">
                                <img src="{{ route('appeals.response-photo', ['appeal' => $appeal, 'photoId' => $photo->id]) }}" alt="Фотоотчёт {{ $loop->iteration }}">
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
            <div class="appeal-detail-response-meta">
                {{ $appeal->responded_at->format('d.m.Y H:i') }}
                @if($appeal->responder)
                    — {{ $appeal->responder->name }}
                @endif
            </div>
        </div>
        @else
        <form action="{{ route('staff.appeals.respond', $appeal) }}" method="POST" class="appeal-respond-form" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="response" class="form-label">Текст ответа <span class="required">*</span></label>
                <textarea name="response" id="response" class="form-control @error('response') is-invalid @enderror js-summernote" rows="6" required>{{ old('response') }}</textarea>
                @error('response')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label for="response_photos" class="form-label">Фотоотчёт по выполненным работам</label>
                <input type="file" name="response_photos[]" id="response_photos" class="form-control @error('response_photos') is-invalid @enderror @error('response_photos.*') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png,image/webp" multiple>
                <small class="form-text text-muted">До 10 фотографий, каждое фото до 5 МБ.</small>
                @error('response_photos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                @error('response_photos.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
.appeal-response-text p { margin: 0 0 0.7em; }
.appeal-response-text ul, .appeal-response-text ol { margin: 0.7em 0 0.7em 1.2em; padding-left: 1em; }
.appeal-response-text ul { list-style: disc; }
.appeal-response-text ol { list-style: decimal; }
.appeal-detail-response-meta { font-size: 13px; color: #666; margin-top: 10px; }
.appeal-respond-form { margin-top: 24px; padding-top: 20px; border-top: 1px solid #e8e8e8; }
.required { color: #dc3545; }
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
.appeal-response-photos { margin-top: 14px; }
.appeal-response-photos-title { margin: 0 0 8px; color: #1a3c1a; font-size: 0.98rem; }
.appeal-response-photos-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 10px; }
.appeal-response-photo-link { display: block; border-radius: 6px; overflow: hidden; border: 1px solid #e0e0e0; background: #fff; }
.appeal-response-photo-link img { width: 100%; height: 100px; object-fit: cover; display: block; }
</style>
@endsection
