@extends('layouts.app')

@section('title', $honorary->exists ? 'Редактировать' : 'Добавить')

@section('content')
<div class="staff-content-form">
    <h1>{{ $honorary->exists ? 'Редактировать почётного гражданина' : 'Добавить почётного гражданина' }}</h1>
    <a href="{{ route('staff.content.honorary') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $honorary->exists ? route('staff.content.honorary.update', $honorary) : route('staff.content.honorary.store') }}" method="POST">
        @csrf
        @if($honorary->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Категория (подраздел) *</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $honorary->category) }}" required placeholder="Напр. Почётные граждане Сергиево-Посадского района">
            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">ФИО *</label>
            <input type="text" name="person_name" class="form-control" value="{{ old('person_name', $honorary->person_name) }}" required>
            @error('person_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Сведения о человеке</label>
            <textarea name="person_info" class="form-control" rows="2">{{ old('person_info', $honorary->person_info) }}</textarea>
            @error('person_info')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Кем и когда присвоено звание *</label>
            <input type="text" name="awarded_by" class="form-control" value="{{ old('awarded_by', $honorary->awarded_by) }}" required>
            @error('awarded_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $honorary->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.honorary') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
