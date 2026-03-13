@extends('layouts.app')

@section('title', 'Администрация — Глава и заместители')

@section('content')
<div class="staff-administration">
    <h1>Администрация — Глава и заместители</h1>
    <a href="{{ route('staff.articles.index') }}" class="btn btn-sm" style="margin-bottom: 20px;">← К статьям</a>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <section class="admin-edit-section">
        <h2 class="section-title">Глава округа</h2>
        @if($head && $head->title)
            <p>{{ $head->title }}</p>
            <a href="{{ route('staff.administration.editHead') }}" class="btn btn-warning btn-sm">Редактировать главу</a>
        @else
            <p>Запись о главе пока не заполнена.</p>
            <a href="{{ route('staff.administration.editHead') }}" class="btn btn-primary btn-sm">Добавить / редактировать главу</a>
        @endif
    </section>

    <section class="admin-edit-section">
        <h2 class="section-title">Заместители главы</h2>
        <a href="{{ route('staff.administration.createDeputy') }}" class="btn btn-primary btn-sm" style="margin-bottom: 16px;">Добавить заместителя</a>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Должность</th>
                        <th>Порядок</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deputies as $d)
                    <tr>
                        <td>{{ $d->name }}</td>
                        <td>{{ Str::limit($d->position, 50) }}</td>
                        <td>{{ $d->sort_order }}</td>
                        <td class="actions">
                            <a href="{{ route('staff.administration.editDeputy', $d) }}" class="btn btn-warning btn-sm">Редактировать</a>
                            <form action="{{ route('staff.administration.destroyDeputy', $d) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить заместителя?">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Нет заместителей. Добавьте запись.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <p style="margin-top: 24px;">
        <a href="{{ route('administration') }}" class="btn" target="_blank">Открыть страницу «Администрация» на сайте</a>
    </p>
</div>

<style>
.staff-administration { padding: 20px 0; max-width: 900px; }
.staff-administration h1 { color: #1a3c1a; margin-bottom: 16px; }
.admin-edit-section { margin-bottom: 32px; }
.admin-edit-section .section-title { font-size: 1.15rem; color: #1a3c1a; margin-bottom: 12px; border-bottom: 1px solid #e0e0e0; padding-bottom: 6px; }
.actions { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
</style>
@endsection
