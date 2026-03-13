@extends('layouts.app')

@section('title', 'Редактировать главу округа')

@section('content')
<div class="staff-administration-form">
    <h1>Редактировать главу округа</h1>
    <a href="{{ route('staff.administration.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К разделу Администрация</a>

    <form action="{{ route('staff.administration.updateHead') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Фото</label>
            @if($head->photoUrl())
                <div class="current-photo">
                    <img src="{{ $head->photoUrl() }}" alt="" style="max-width: 200px; height: auto; border-radius: 8px; display: block; margin-bottom: 8px;">
                    <label><input type="checkbox" name="photo_remove" value="1"> Удалить текущее фото</label>
                </div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">ФИО / заголовок *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $head->title) }}" required maxlength="255">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="14">{{ old('description', $head->description) }}</textarea>
            <small class="form-hint">Каждый абзац — с новой строки (двойной перенос строки между абзацами).</small>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.administration.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-administration-form { padding: 20px 0; max-width: 700px; }
.staff-administration-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
.form-hint { display: block; margin-top: 4px; color: #666; font-size: 0.9rem; }
</style>
@endsection
