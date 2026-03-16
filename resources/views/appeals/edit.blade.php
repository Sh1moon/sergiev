@extends('layouts.app')

@section('title', 'Редактирование обращения #' . $appeal->id)

@section('content')
<div class="appeals-page appeals-edit">
    <a href="{{ route('appeals.show', $appeal) }}" class="btn btn-sm" style="margin-bottom: 20px;">← К обращению</a>

    <h1 class="appeals-title">Редактирование обращения #{{ $appeal->id }}</h1>
    <p class="appeals-intro">Измените нужные поля и нажмите «Сохранить». Ответ на обращение ещё не дан, поэтому редактирование доступно.</p>

    <form action="{{ route('appeals.update', $appeal) }}" method="POST" class="appeals-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="fio" class="form-label">ФИО <span class="required">*</span></label>
            <input type="text" name="fio" id="fio" class="form-control @error('fio') is-invalid @enderror"
                   value="{{ old('fio', $appeal->fio) }}" required maxlength="255" autocomplete="name">
            @error('fio')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="postal_address" class="form-label">Почтовый адрес</label>
            <input type="text" name="postal_address" id="postal_address" class="form-control @error('postal_address') is-invalid @enderror"
                   value="{{ old('postal_address', $appeal->postal_address) }}" maxlength="500" autocomplete="street-address">
            @error('postal_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="email" class="form-label">Адрес электронной почты <span class="required">*</span></label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $appeal->email) }}" required maxlength="255" autocomplete="email">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Номер телефона</label>
            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone', $appeal->phone) }}" maxlength="50" autocomplete="tel">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="body" class="form-label">Текст обращения <span class="required">*</span></label>
            <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="6"
                      required maxlength="10000" placeholder="Опишите суть обращения...">{{ old('body', $appeal->body) }}</textarea>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label for="attachment" class="form-label">Прикрепить файл</label>
            @if($appeal->attachment)
            <div class="current-attachment">
                <span class="current-attachment-label">Текущий файл:</span>
                @if($appeal->isImageAttachment())
                    <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener" class="js-img-lightbox appeal-edit-thumb">
                        <img src="{{ route('appeals.attachment', $appeal) }}" alt="Текущее вложение" class="appeal-edit-thumb-img">
                    </a>
                @else
                    <a href="{{ route('appeals.attachment', $appeal) }}" target="_blank" rel="noopener">{{ $appeal->attachmentOriginalName() }}</a>
                @endif
                <span class="form-hint">Загрузите новый файл, чтобы заменить.</span>
            </div>
            @endif
            <input type="file" name="attachment" id="attachment" class="form-control"
                   accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
            <span class="form-hint">До 10 МБ. Форматы: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG.</span>
            @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
            <a href="{{ route('appeals.show', $appeal) }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.appeals-edit { padding: 20px 0; max-width: 640px; }
.current-attachment { margin-bottom: 12px; padding: 12px; background: #f5f5f5; border-radius: 6px; }
.current-attachment-label { display: block; font-weight: 500; margin-bottom: 8px; color: #1a3c1a; }
.appeal-edit-thumb { display: inline-block; }
.appeal-edit-thumb-img { max-width: 200px; max-height: 150px; object-fit: contain; border-radius: 4px; border: 1px solid #e8e8e8; cursor: pointer; }
</style>
@endsection
