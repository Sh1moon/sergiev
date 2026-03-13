@extends('layouts.app')

@section('title', $institution->exists ? 'Редактировать учреждение' : 'Добавить учреждение')

@section('content')
<div class="staff-content-form">
    <h1>{{ $institution->exists ? 'Редактировать учреждение' : 'Добавить учреждение' }}</h1>
    <a href="{{ route('staff.content.institutions') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $institution->exists ? route('staff.content.institutions.update', $institution) : route('staff.content.institutions.store') }}" method="POST">
        @csrf
        @if($institution->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Название *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $institution->title) }}" required>
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Руководитель</label>
            <input type="text" name="leader" class="form-control" value="{{ old('leader', $institution->leader) }}">
            @error('leader')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Адрес</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $institution->address) }}">
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Телефоны</label>
            <input type="text" name="phones" class="form-control" value="{{ old('phones', $institution->phones) }}">
            @error('phones')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">E-mail</label>
            <input type="text" name="email" class="form-control" value="{{ old('email', $institution->email) }}">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Сайт (URL)</label>
            <input type="text" name="website" class="form-control" value="{{ old('website', $institution->website) }}">
            @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Описание</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $institution->description) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $institution->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.institutions') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
