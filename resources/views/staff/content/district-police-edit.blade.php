@extends('layouts.app')

@section('title', $entry->exists ? 'Редактировать участок' : 'Добавить участок')

@section('content')
<div class="staff-content-form">
    <h1>{{ $entry->exists ? 'Редактировать участок' : 'Добавить участок' }}</h1>
    <a href="{{ route('staff.content.district-police.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $entry->exists ? route('staff.content.district-police.update', $entry) : route('staff.content.district-police.store') }}" method="POST">
        @csrf
        @if($entry->exists) @method('PUT') @endif

        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $entry->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Административный участок</label>
            <input type="text" name="admin_district" class="form-control" value="{{ old('admin_district', $entry->admin_district) }}" placeholder="Например: Территория г. Сергиев Посад. Административный участок № 1">
            @error('admin_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Ответственный</label>
            <textarea name="responsible" class="form-control" rows="2">{{ old('responsible', $entry->responsible) }}</textarea>
            @error('responsible')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Замещает ответственного</label>
            <textarea name="substitute" class="form-control" rows="2">{{ old('substitute', $entry->substitute) }}</textarea>
            @error('substitute')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Жилой сектор</label>
            <textarea name="residential_sector" class="form-control" rows="6">{{ old('residential_sector', $entry->residential_sector) }}</textarea>
            @error('residential_sector')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Дни приема граждан</label>
            <textarea name="reception_days" class="form-control" rows="3">{{ old('reception_days', $entry->reception_days) }}</textarea>
            @error('reception_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Дни приема ответственного от руководства</label>
            <textarea name="leadership_reception_days" class="form-control" rows="2">{{ old('leadership_reception_days', $entry->leadership_reception_days) }}</textarea>
            @error('leadership_reception_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Место приема граждан</label>
            <textarea name="reception_place" class="form-control" rows="3">{{ old('reception_place', $entry->reception_place) }}</textarea>
            @error('reception_place')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.district-police.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
