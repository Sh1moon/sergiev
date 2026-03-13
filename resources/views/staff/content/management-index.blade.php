@extends('layouts.app')

@section('title', 'Управляющие компании')

@section('content')
<div class="staff-content-section">
    <h1>Управляющие компании</h1>
    <a href="{{ route('staff.content.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку разделов</a>
    <a href="{{ route('staff.content.management.create') }}" class="btn btn-primary btn-sm" style="margin-bottom: 16px;">Добавить запись</a>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <h3>Управляющие организации</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Содержимое</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($managing as $row)
                <tr>
                    <td>{{ $row->num }}</td>
                    <td>{{ Str::limit(strip_tags($row->content), 80) }}</td>
                    <td class="actions">
                        <a href="{{ route('staff.content.management.edit', $row) }}" class="btn btn-warning btn-sm">Изменить</a>
                        <form action="{{ route('staff.content.management.destroy', $row) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить эту запись?">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Нет записей.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <h3 style="margin-top: 32px;">Ресурсоснабжающие организации</h3>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Содержимое</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resource as $row)
                <tr>
                    <td>{{ $row->num }}</td>
                    <td>{{ Str::limit(strip_tags($row->content), 80) }}</td>
                    <td class="actions">
                        <a href="{{ route('staff.content.management.edit', $row) }}" class="btn btn-warning btn-sm">Изменить</a>
                        <form action="{{ route('staff.content.management.destroy', $row) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить эту запись?">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Нет записей.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
.staff-content-section { padding: 20px 0; max-width: 1000px; }
.staff-content-section h1 { color: #1a3c1a; margin-bottom: 16px; }
.staff-content-section h3 { color: #1a3c1a; font-size: 1.1rem; margin-bottom: 12px; }
.actions { display: flex; flex-wrap: wrap; gap: 8px; }
</style>
@endsection
