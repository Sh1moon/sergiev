@extends('layouts.app')

@section('title', 'Обращения граждан')

@section('content')
<div class="staff-appeals">
    <h1>Обращения граждан</h1>

    <form method="get" class="appeals-toolbar">
        <div class="appeals-search-wrap">
            <input type="text" name="q" value="{{ $search }}" class="form-control appeals-search" placeholder="Поиск по ФИО, email, тексту...">
            <select name="filter" class="form-control appeals-filter">
                <option value="new" {{ $filter === 'new' ? 'selected' : '' }}>Новые (без ответа)</option>
                <option value="archived" {{ $filter === 'archived' ? 'selected' : '' }}>Архив (с ответом)</option>
            </select>
            <button type="submit" class="btn btn-primary">Найти</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>ФИО</th>
                    <th>Контакты</th>
                    <th>Текст</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($appeals as $appeal)
                <tr>
                    <td>{{ $appeal->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $appeal->fio }}</td>
                    <td>
                        {{ $appeal->email }}
                        @if($appeal->phone)<br><small>{{ $appeal->phone }}</small>@endif
                    </td>
                    <td class="appeal-body-cell">{{ Str::limit($appeal->body, 80) }}</td>
                    <td>
                        @if($appeal->responded_at)
                            <span class="badge badge-answered">Ответ дан</span>
                        @else
                            <span class="badge badge-new">Новое</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('staff.appeals.show', $appeal) }}" class="btn btn-sm btn-primary">Открыть</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">Нет обращений</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $appeals->links() }}
</div>

<style>
.staff-appeals { padding: 20px 0; }
.staff-appeals h1 { color: #1a3c1a; margin-bottom: 24px; }
.appeals-toolbar { margin-bottom: 24px; }
.appeals-search-wrap { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.appeals-search { max-width: 280px; }
.appeals-filter { width: auto; min-width: 180px; }
.appeal-body-cell { max-width: 200px; }
.badge-new { background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
.badge-answered { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
.btn-sm { padding: 6px 12px; font-size: 14px; }
</style>
@endsection
