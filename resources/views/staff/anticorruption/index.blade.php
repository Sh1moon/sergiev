@extends('layouts.app')

@section('title', 'Сообщения об антикоррупции')

@section('content')
<div class="staff-anticorruption">
    <h1>Сообщения об антикоррупции</h1>

    <form method="get" class="reports-toolbar">
        <div class="reports-search-wrap">
            <input type="text" name="q" value="{{ $search }}" class="form-control reports-search" placeholder="Поиск по email, тексту...">
            <select name="filter" class="form-control reports-filter">
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
                    <th>E-mail</th>
                    <th>Текст</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td>{{ $report->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ $report->email }}</td>
                    <td class="report-body-cell">{{ Str::limit($report->body, 80) }}</td>
                    <td>
                        @if($report->responded_at)
                            <span class="badge badge-answered">Ответ дан</span>
                        @else
                            <span class="badge badge-new">Новое</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('staff.anticorruption.show', $report) }}" class="btn btn-sm btn-primary">Открыть</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Нет сообщений</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reports->links() }}
</div>

<style>
.staff-anticorruption { padding: 20px 0; }
.staff-anticorruption h1 { color: #1a3c1a; margin-bottom: 24px; }
.reports-toolbar { margin-bottom: 24px; }
.reports-search-wrap { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
.reports-search { max-width: 280px; }
.reports-filter { width: auto; min-width: 180px; }
.report-body-cell { max-width: 200px; }
.badge-new { background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
.badge-answered { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
.btn-sm { padding: 6px 12px; font-size: 14px; }
</style>
@endsection
