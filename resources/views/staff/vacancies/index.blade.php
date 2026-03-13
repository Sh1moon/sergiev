@extends('layouts.app')

@section('title', 'Вакансии')

@section('content')
<div class="staff-vacancies">
    <div class="page-header" style="margin-bottom: 10px;">
        <h1>Вакансии</h1>
        <a href="{{ route('staff.vacancies.create') }}" class="btn btn-primary">Добавить вакансию</a>
    </div>

    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Дата публикации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vacancies as $vacancy)
                <tr>
                    <td>{{ $vacancy->title }}</td>
                    <td>{{ $vacancy->published_at ? $vacancy->published_at->format('d.m.Y') : '—' }}</td>
                    <td class="actions">
                        @if($vacancy->published_at && $vacancy->published_at->lte(now()))
                            <a href="{{ route('vacancy.show', $vacancy->slug) }}" class="btn btn-sm" target="_blank">Просмотр</a>
                        @endif
                        <a href="{{ route('staff.vacancies.edit', $vacancy) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        <form action="{{ route('staff.vacancies.destroy', $vacancy) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить вакансию?">Удалить</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">Нет вакансий.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $vacancies->links() }}
</div>
@endsection
