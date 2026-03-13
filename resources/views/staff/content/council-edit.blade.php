@extends('layouts.app')

@section('title', $council->exists ? 'Редактировать депутата' : 'Добавить депутата')

@section('content')
<div class="staff-content-form">
    <h1>{{ $council->exists ? 'Редактировать депутата' : 'Добавить депутата' }}</h1>
    <a href="{{ route('staff.content.council') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $council->exists ? route('staff.content.council.update', $council) : route('staff.content.council.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($council->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Фото</label>
            @if($council->exists && $council->photoUrl())
                <div class="current-photo">
                    <img src="{{ $council->photoUrl() }}" alt="" style="max-width: 150px; height: auto; border-radius: 8px; display: block; margin-bottom: 8px;">
                    <label><input type="checkbox" name="photo_remove" value="1"> Удалить текущее фото</label>
                </div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">ФИО *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $council->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Информация (округ, партия и т.д.)</label>
            <textarea name="info" class="form-control" rows="6">{{ old('info', $council->info) }}</textarea>
            @error('info')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Контакты (телефон, email, VK, приём)</label>
            <textarea name="contacts" class="form-control" rows="4">{{ old('contacts', $council->contacts) }}</textarea>
            @error('contacts')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $council->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.council') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
