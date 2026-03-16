@extends('layouts.app')

@section('title', 'Отдел участковых по району')

@section('content')
<div class="staff-content-section">
    <h1>Отдел участковых по району</h1>
    <a href="{{ route('staff.content.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку разделов</a>
    <a href="{{ route('staff.content.district-police.create') }}" class="btn btn-primary btn-sm" style="margin-bottom: 16px;">Добавить участок</a>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="alert alert-danger">{{ session('error') }}</p>
    @endif

    <p class="text-muted" style="margin-bottom: 16px;">Текст из файла <code>resources/data/district_police.txt</code> (при отсутствии — <code>database/seeders/data/district_police_raw.txt</code>) можно загрузить в редактор кнопкой ниже. Существующие записи будут заменены.</p>
    <form action="{{ route('staff.content.district-police.import') }}" method="POST" style="display: inline-block; margin-bottom: 16px;">
        @csrf
        <button type="submit" class="btn btn-secondary btn-sm">Импортировать текст из файла в редактор</button>
    </form>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Порядок</th>
                    <th>Административный участок</th>
                    <th>Ответственный</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                <tr>
                    <td>{{ $entry->sort_order }}</td>
                    <td>{{ Str::limit($entry->admin_district, 60) ?: '—' }}</td>
                    <td>{{ Str::limit($entry->responsible, 50) ?: '—' }}</td>
                    <td class="actions">
                        <a href="{{ route('staff.content.district-police.edit', $entry) }}" class="btn btn-warning btn-sm">Изменить</a>
                        <form action="{{ route('staff.content.district-police.destroy', $entry) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить эту запись?">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">Нет записей. Добавьте первый участок.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.staff-content-section { padding: 20px 0; max-width: 1100px; }
.staff-content-section h1 { color: #1a3c1a; margin-bottom: 16px; }
.actions { display: flex; flex-wrap: wrap; gap: 8px; }
</style>
@endsection
