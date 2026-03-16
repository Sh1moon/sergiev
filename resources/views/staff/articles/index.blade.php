@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
<div class="staff-articles">
    <div class="page-header">
        <h1>Статьи</h1>
        <a href="{{ route('staff.articles.create', isset($filterSectionId) && $filterSectionId ? ['section' => $sections->firstWhere('id', $filterSectionId)?->slug] : []) }}" class="btn btn-primary">Добавить статью</a>
    </div>

    <form method="get" class="filter-form">
        <label for="section_id">Раздел:</label>
        <select name="section_id" id="section_id" onchange="this.form.submit()">
            <option value="">Все разделы</option>
            @foreach($sections as $s)
            <option value="{{ $s->id }}" {{ (request('section_id') ?: ($filterSectionId ?? null)) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Заголовок</th>
                    <th>Раздел</th>
                    <th>Дата публикации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->section->name ?? '—' }}</td>
                    <td>{{ $article->published_at ? $article->published_at->format('d.m.Y') : '—' }}</td>
                    <td class="actions">
                        @if($article->section->slug === 'news')
                            <a href="{{ route('news.show', $article->slug) }}" class="btn btn-sm" target="_blank">Просмотр</a>
                        @elseif($article->section->slug === 'go-chs')
                            <a href="{{ route('go-chs.show', $article->slug) }}" class="btn btn-sm" target="_blank">Просмотр</a>
                        @else
                            <a href="{{ route('articles.show', [$article->section->slug, $article->slug]) }}" class="btn btn-sm" target="_blank">Просмотр</a>
                        @endif
                        <a href="{{ route('staff.articles.edit', $article) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('staff.articles.destroy', $article) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить статью?">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">Нет статей</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $articles->withQueryString()->links() }}
</div>

<style>
.staff-articles { padding: 20px 0; }
.page-header { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; }
.page-header h1 { color: #1a3c1a; }
.filter-form { margin-bottom: 20px; }
.filter-form select { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; }
.actions { white-space: nowrap; }
.actions .btn { margin-right: 6px; }
.btn-sm { padding: 6px 12px; font-size: 14px; }
</style>
@endsection
