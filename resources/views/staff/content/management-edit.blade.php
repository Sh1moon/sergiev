@extends('layouts.app')

@section('title', $row->exists ? 'Редактировать' : 'Добавить')

@section('content')
<div class="staff-content-form">
    <h1>{{ $row->exists ? 'Редактировать запись' : 'Добавить запись' }}</h1>
    <a href="{{ route('staff.content.management') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $row->exists ? route('staff.content.management.update', $row) : route('staff.content.management.store') }}" method="POST">
        @csrf
        @if($row->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Раздел *</label>
            <select name="section" class="form-control" required>
                <option value="managing" {{ old('section', $row->section) === 'managing' ? 'selected' : '' }}>Управляющие организации</option>
                <option value="resource" {{ old('section', $row->section) === 'resource' ? 'selected' : '' }}>Ресурсоснабжающие организации</option>
            </select>
            @error('section')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">№ *</label>
            <input type="text" name="num" class="form-control" value="{{ old('num', $row->num) }}" required>
            @error('num')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Содержимое (название, адрес, руководитель, телефон, email) *</label>
            <textarea name="content" class="form-control" rows="8" required>{{ old('content', $row->content) }}</textarea>
            @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $row->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.management') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
