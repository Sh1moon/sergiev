@extends('layouts.app')

@section('title', 'Управление пользователями')

@section('content')
<div class="users-index">
    <div class="page-header">
        <h1>Управление пользователями</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Создать пользователя</a>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role)
                            <span class="badge badge-{{ $user->role->slug }}">
                                {{ $user->role->name }}
                            </span>
                        @else
                            <span class="badge badge-none">Нет роли</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm js-confirm-delete" data-confirm-message="Удалить этого пользователя?">Удалить</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
</div>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-header h1 {
    color: #1a3c1a;
}

.table-responsive {
    overflow-x: auto;
}

.actions {
    white-space: nowrap;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 14px;
    margin: 0 2px;
}

.badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
}

.badge-admin {
    background-color: #eac31b;
    color: #1a3c1a;
}

.badge-employee {
    background-color: #4a6fa5;
    color: #fafffa;
}

.badge-user {
    background-color: #6c757d;
    color: #fafffa;
}

.badge-none {
    background-color: #dc3545;
    color: #fafffa;
}

.pagination {
    margin-top: 30px;
    text-align: center;
}
</style>
@endsection