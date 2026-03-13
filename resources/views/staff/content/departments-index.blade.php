@extends('layouts.app')

@section('title', 'Подразделения')

@section('content')
<div class="staff-content-section">
    <h1>Подразделения</h1>
    <a href="{{ route('staff.content.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку разделов</a>
    <a href="{{ route('staff.content.departments.create') }}" class="btn btn-primary btn-sm" style="margin-bottom: 16px;">Добавить подразделение</a>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Управление</th>
                    <th>Руководитель</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->management_name }}</td>
                    <td>{{ Str::limit($item->head_text, 60) }}</td>
                    <td class="actions">
                        <a href="{{ route('staff.content.departments.edit', $item) }}" class="btn btn-warning btn-sm">Изменить</a>
                        <form action="{{ route('staff.content.departments.destroy', $item) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить это подразделение?">Удалить</button>
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
.actions { display: flex; flex-wrap: wrap; gap: 8px; }
</style>
@endsection
