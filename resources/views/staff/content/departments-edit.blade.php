@extends('layouts.app')

@section('title', $department->exists ? 'Редактировать подразделение' : 'Добавить подразделение')

@section('content')
<div class="staff-content-form">
    <h1>{{ $department->exists ? 'Редактировать подразделение' : 'Добавить подразделение' }}</h1>
    <a href="{{ route('staff.content.departments') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $department->exists ? route('staff.content.departments.update', $department) : route('staff.content.departments.store') }}" method="POST">
        @csrf
        @if($department->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Название управления *</label>
            <input type="text" name="management_name" class="form-control" value="{{ old('management_name', $department->management_name) }}" required>
            @error('management_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Руководитель (ФИО, тел.)</label>
            <input type="text" name="head_text" class="form-control" value="{{ old('head_text', $department->head_text) }}">
            @error('head_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">График приёма (если есть)</label>
            <input type="text" name="schedule_text" class="form-control" value="{{ old('schedule_text', $department->schedule_text) }}">
            @error('schedule_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Список отделов (каждая строка — отдел и руководитель)</label>
            <textarea name="body" class="form-control" rows="12">{{ old('body', $department->body) }}</textarea>
            <small>Формат: <strong>Название отдела</strong> — ФИО, контакты. Каждый отдел с новой строки.</small>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $department->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.departments') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
