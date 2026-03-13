@extends('layouts.app')

@section('title', 'Почётные граждане')

@section('content')
<div class="staff-content-section">
    <h1>Почётные граждане</h1>
    <a href="{{ route('staff.content.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К списку разделов</a>
    <a href="{{ route('staff.content.honorary.create') }}" class="btn btn-primary btn-sm" style="margin-bottom: 16px;">Добавить запись</a>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Категория</th>
                    <th>ФИО / сведения</th>
                    <th>Кем присвоено</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->category }}</td>
                    <td>{{ Str::limit($item->person_name . ($item->person_info ? ' — ' . $item->person_info : ''), 60) }}</td>
                    <td>{{ Str::limit($item->awarded_by, 50) }}</td>
                    <td class="actions">
                        <a href="{{ route('staff.content.honorary.edit', $item) }}" class="btn btn-warning btn-sm">Изменить</a>
                        <form action="{{ route('staff.content.honorary.destroy', $item) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить запись?">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4">Нет записей. Добавьте первую.</td></tr>
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
