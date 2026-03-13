@extends('layouts.app')

@section('title', $deputy->exists ? 'Редактировать заместителя' : 'Добавить заместителя')

@section('content')
<div class="staff-administration-form">
    <h1>{{ $deputy->exists ? 'Редактировать заместителя' : 'Добавить заместителя' }}</h1>
    <a href="{{ route('staff.administration.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К разделу Администрация</a>

    <form action="{{ $deputy->exists ? route('staff.administration.updateDeputy', $deputy) : route('staff.administration.storeDeputy') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($deputy->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Фото</label>
            @if($deputy->exists && $deputy->photoUrl())
                <div class="current-photo">
                    <img src="{{ $deputy->photoUrl() }}" alt="" style="max-width: 150px; height: auto; border-radius: 8px; display: block; margin-bottom: 8px;">
                    <label><input type="checkbox" name="photo_remove" value="1"> Удалить текущее фото</label>
                </div>
            @endif
            <input type="file" name="photo" class="form-control" accept="image/*">
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">ФИО *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $deputy->name) }}" required maxlength="255">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Должность</label>
            <input type="text" name="position" class="form-control" value="{{ old('position', $deputy->position) }}" maxlength="500">
            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="6">{{ old('description', $deputy->description) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Контакты (телефон, кабинет и т.д.)</label>
            <input type="text" name="contacts" class="form-control" value="{{ old('contacts', $deputy->contacts) }}" maxlength="500">
            @error('contacts')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок отображения</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $deputy->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
</style>
@endsection
