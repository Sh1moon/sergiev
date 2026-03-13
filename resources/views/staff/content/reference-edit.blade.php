@extends('layouts.app')

@section('title', 'Редактировать раздел')

@section('content')
<div class="staff-content-form">
    <h1>{{ $titles[$section->slug] ?? $section->slug }}</h1>
    <a href="{{ route('staff.content.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку разделов</a>

    <form action="{{ route('staff.content.reference.update', $section->slug) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Содержимое</label>
            <textarea name="content" class="form-control" rows="25">{{ old('content', $section->content) }}</textarea>
            <small>Текст с переносами строк. Для «Участковых» — используйте структуру с «Ответственный:», «Замещает ответственного:». Для «Экстренных служб» — строки вида «Название — телефон».</small>
            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 800px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
