@extends('layouts.app')

@section('title', $territory->exists ? 'Редактировать' : 'Добавить')

@section('content')
<div class="staff-content-form">
    <h1>{{ $territory->exists ? 'Редактировать территорию' : 'Добавить территорию' }}</h1>
    <a href="{{ route('staff.content.territories') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ $territory->exists ? route('staff.content.territories.update', $territory) : route('staff.content.territories.store') }}" method="POST">
        @csrf
        @if($territory->exists) @method('PUT') @endif
        <div class="form-group">
            <label class="form-label">Управление / территория *</label>
            <input type="text" name="management" class="form-control" value="{{ old('management', $territory->management) }}" required>
            @error('management')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Руководитель</label>
            <input type="text" name="leader" class="form-control" value="{{ old('leader', $territory->leader) }}">
            @error('leader')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Телефон, e-mail</label>
            <textarea name="contacts" class="form-control" rows="2">{{ old('contacts', $territory->contacts) }}</textarea>
            @error('contacts')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Адрес</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $territory->address) }}">
            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Порядок</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $territory->sort_order ?? 0) }}" min="0">
            @error('sort_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.content.territories') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-content-form { padding: 20px 0; max-width: 700px; }
.staff-content-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
