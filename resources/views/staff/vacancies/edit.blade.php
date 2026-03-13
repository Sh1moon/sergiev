@extends('layouts.app')

@section('title', 'Редактировать вакансию')

@section('content')
<div class="staff-vacancy-form">
    <h1>Редактировать вакансию</h1>
    <a href="{{ route('staff.vacancies.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ route('staff.vacancies.update', $vacancy) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Название должности *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $vacancy->title) }}" required maxlength="255">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Описание, требования</label>
            <textarea name="body" class="form-control" rows="12">{{ old('body', $vacancy->body) }}</textarea>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Дата публикации</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $vacancy->published_at?->format('Y-m-d\TH:i')) }}">
            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.vacancies.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-vacancy-form { padding: 20px 0; max-width: 700px; }
.staff-vacancy-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
