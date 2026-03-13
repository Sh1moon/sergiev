@extends('layouts.app')

@section('title', 'Редактировать статью')

@section('content')
<div class="staff-article-form">
    <h1>Редактировать статью</h1>
    <a href="{{ route('staff.articles.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку</a>

    <form action="{{ route('staff.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label">Раздел *</label>
            <select name="article_section_id" class="form-control" required>
                @foreach($sections as $s)
                <option value="{{ $s->id }}" {{ old('article_section_id', $article->article_section_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @error('article_section_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Заголовок *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}" required maxlength="255">
            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Краткое описание</label>
            <textarea name="excerpt" class="form-control" rows="2" maxlength="500">{{ old('excerpt', $article->excerpt) }}</textarea>
            @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Текст статьи</label>
            <textarea name="body" class="form-control" rows="12">{{ old('body', $article->body) }}</textarea>
            @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Изображение</label>
            @if($article->image)
            <p><img src="{{ Storage::url($article->image) }}" alt="" style="max-width: 200px; height: auto; border-radius: 4px;"></p>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Дата публикации</label>
            <input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}">
            @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="form-group">
            <label class="form-label">Добавить файлы</label>
            <input type="file" name="files[]" class="form-control" multiple accept=".pdf,.doc,.docx,.xls,.xlsx">
        </div>
        @if($article->files->isNotEmpty())
        <div class="form-group">
            <label class="form-label">Прикреплённые файлы</label>
            <ul class="file-list">
                @foreach($article->files as $file)
                <li>
                    <a href="{{ Storage::url($file->path) }}" target="_blank" rel="noopener">{{ $file->original_name }}</a>
                    <form action="{{ route('staff.articles.files.destroy', [$article, $file]) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить файл?">Удалить</button>
                    </form>
                </li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <a href="{{ route('staff.articles.index') }}" class="btn">Отмена</a>
        </div>
    </form>
</div>

<style>
.staff-article-form { padding: 20px 0; max-width: 700px; }
.staff-article-form h1 { color: #1a3c1a; margin-bottom: 16px; }
.form-actions { margin-top: 24px; display: flex; gap: 12px; }
.file-list { list-style: none; padding: 0; }
.file-list li { margin-bottom: 8px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
</style>
@endsection
