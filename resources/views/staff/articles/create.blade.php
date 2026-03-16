@extends('layouts.app')

@section('title', 'Добавить статью')

@section('content')
<div class="staff-article-form">
    <h1>Добавить статью</h1>
    <a href="{{ route('staff.articles.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ route('staff.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label class="form-label">Раздел *</label>
            <select name="article_section_id" class="form-control" required>
                @foreach($sections as $s)
                <option value="{{ $s->id }}" {{ (old('article_section_id', $defaultSectionId ?? null) == $s->id) ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @error('article_section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Заголовок *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required maxlength="255">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Краткое описание</label>
            <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt') }}</textarea>
            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Текст статьи</label>
            <textarea name="body" class="form-control" rows="12">{{ old('body') }}</textarea>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Изображение</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Дата публикации</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Файлы (открываются в новой вкладке)</label>
            <input type="file" name="files[]" class="form-control" multiple accept=".pdf,.doc,.docx,.xls,.xlsx">
            @error('files.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Создать</button>
            <a href="{{ route('staff.articles.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-article-form { padding: 20px 0; max-width: 700px; }
.staff-article-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
</style>
@endsection
